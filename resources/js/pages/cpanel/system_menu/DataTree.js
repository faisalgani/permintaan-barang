import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {encryptParameter} from '../../../service/ServiceParams';
import * as ExternalAPI from '../../../service/ExternalAPI';

var dataTreeJSON = [];
export default class DataTree extends Component {
    constructor(props) {
        super(props);
        this.state  = {
            disableBtnSave: false,
            showLoadingSave: false,
            disableBtnAdd: false,
            showLoading: false,
            disableBtn: false,
            url: props.url,
            id_user: props.id_user,
            active: "",
            pages: 0,
            total: 0,
            dataTree: [],
            ktdataTree:{},
            limitChar: 100, 
            loading: false,
            datatable: {},
            header          : {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                "Access-Control-Allow-Origin": "*",
                'X-CSRF-TOKEN': props.token,
            },
        }
        this.btnSave = this.btnSave.bind(this);
        this.btnChange = this.btnChange.bind(this);
    }

    async btnChange(e){
        location.href = this.state.url+"/admin/system_menu/form/"+$("#id").val();
    }

    async processReorder(index, element){
        var $this = this;
        return new Promise(async function(resolve) {
            var parameter = await encryptParameter({
                id: element.id,
                order: element.order,
                parent: element.parent,
            });
            var result = await ExternalAPI.post($this.state.url+'/api/v1/system_menu/update/position', $this.state.header, parameter);
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
                    resolve();
                }
            }
        });
    }

    async btnSave(){
        await this.setState({
            disableBtnSave: true,
            showLoadingSave: true,
        })
        var jsonNodes = this.state.ktdataTree.jstree(true).get_json('#', { flat: false });
        await jsonNodes.forEach(async (element,index) => {
            index+=1;
            await this.ChildMenu(""+index, element, "");
        });

        for (let index = 0; index < dataTreeJSON.length; index++) {
            await this.processReorder(index, dataTreeJSON[index]);
        }
        await this.setState({
            disableBtnSave: false,
            showLoadingSave: false,
        })
        toastr.info("Posisi menu berhasil di update");
    }

    async ChildMenu(index, data, parent){
        if(data.children.length > 0){
            dataTreeJSON.push({
                id: data.id,
                order: index,
                menu: data.text,
                parent: parent,
            });

            await data.children.forEach(async (element, id) => {
                id+=1;
                await this.ChildMenu(index+"."+id, element, data.id);
            });
        }else{
            dataTreeJSON.push({
                id: data.id,
                order: index,
                menu: data.text,
                parent: parent,
            });
        }
    }

    async treeChild(id, data){
        var dataTree = [];
        await data.forEach(async (element, index) => {
            if(element.parent == id && (element.parent !== "" || element.parent !== null)){
                var icon = element.icon;
                if(element.icon == "" || element.icon == null){
                    icon = "fa fa-file text-waring";
                }
                
                let obj = data.find(o => o.parent === element.id);
                if(typeof(obj) !== "undefined" && (element.icon == "" || element.icon == null)){
                    icon = "fa fa-folder text-success";
                }

                dataTree.push({
                    id: element.id,
                    text: element.menu,
                    link: element.link,
                    active: element.active,
                    class: element.class,
                    parentID: element.parent,
                    icon: icon,
                    children: await this.treeChild(element.id, data),
                });
            }
        });
        return dataTree;
    }

    async componentDidMount() {
        var $this = this;
        var parameter = await encryptParameter({
            id: "",
        });
        var result = await ExternalAPI.get(this.state.url+'/api/v1/system_menu/store', this.state.header);
        var dataTree = [];
        if(typeof(result.code) !== "undefined"){
            if(result.code == 200 && result.count > 0){
                await result.data.forEach(async (element, index) => {
                    if(element.parent == null || element.parent == ""){
                        var icon = element.icon;
                        if(element.icon == "" || element.icon == null){
                            icon = "fa fa-file text-waring";
                        }
                        
                        let obj = result.data.find(o => o.parent === element.id);
                        if(typeof(obj) !== "undefined" && (element.icon == "" || element.icon == null)){
                            icon = "fa fa-folder text-success";
                        }

                        dataTree.push({
                            id: element.id,
                            text: element.menu,
                            link: element.link,
                            active: element.active,
                            class: element.class,
                            parentID: element.parent,
                            icon: icon,
                            children: await this.treeChild(element.id, result.data),
                        });
                    }
                });
            }
        }

        await this.setState({
            dataTree: dataTree,
        })

        await this.setState({
            ktdataTree: await $("#kt_tree").jstree({
                "core": {
                    "themes": {
                        "responsive": false
                    },
                    // so that create works
                    "check_callback": true,
                    "data": $this.state.dataTree
                },
                "types": {
                    "default": {
                        "icon": "fa fa-folder text-success"
                    },
                    "file": {
                        "icon": "fa fa-file  text-success"
                    }
                },
                "state": {
                    "key": "demo2"
                },
                "plugins": ["dnd", "state", "types"]
            })
        });
        
        $('#kt_tree').on('select_node.jstree', async function(e, data) {
            await $("#id").val(data.node.original.id);
            await $("#idTxt").val(data.node.original.id);
            await $("#menu").val(data.node.original.text);
            await $("#link").val(data.node.original.link);
            await $("#class").val(data.node.original.class);
            await $("#active").prop("checked", Boolean(Number(data.node.original.active)));
        });
    }

    render() {
        return (
            <>
                <div className="card-header">
                    <div className="card-tools">
                        <a href={"/admin/system_menu/form"} type="button" disabled={ this.state.disableBtnAdd===false ? "" : "disabled" } className="btn btn-primary mr-2">
                            <span style={{display: this.state.showLoadingAdd ? '' : 'none' }} className="fa fa-spinner fa-pulse fa-sx fa-fw"></span>
                            <span style={{display: this.state.showLoadingAdd ? 'none' : '' }} className="fas fa-plus"></span> Tambah
                        </a>
                        <button type="button" disabled={ this.state.disableBtnSave===false ? "" : "disabled" } onClick={this.btnSave} className="btn btn-primary">
                            <span style={{display: this.state.showLoadingSave ? '' : 'none' }} className="fa fa-spinner fa-pulse fa-sx fa-fw"></span>
                            <span style={{display: this.state.showLoadingSave ? 'none' : '' }} className="fas fa-save"></span> Simpan
                        </button>
                    </div>
                </div>
                <div className="card-body">
                    <div className="row">
                        <div className="col-12">
                            <div className="row">
                                <div className="col-md-6">
                                    <div id="kt_tree" className="tree-demo"></div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label>ID</label>
                                        <input type="hidden" id="id" name="id"/>
                                        <input type="text" id="idTxt" name="idTxt" className="form-control" disabled="disabled" defaultValue={""}/>
                                    </div>
                                    <div className="form-group">
                                        <label>Menu</label>
                                        <input type="text" id="menu" name="menu" className="form-control" disabled="disabled" defaultValue={""}/>
                                    </div>
                                    <div className="form-group">
                                        <label>LInk</label>
                                        <input type="text" id="link" name="link" className="form-control" disabled="disabled" defaultValue={""}/>
                                    </div>
                                    <div className="row">
                                        <div className="col-md-12">
                                            <div className="row">
                                                <div className="col-md-6">
                                                    <div className="form-group">
                                                        <label>Class</label>
                                                        <input type="text" id="class" name="class" className="form-control" disabled="disabled" defaultValue={""}/>
                                                    </div>
                                                </div>
                                                <div className="col-md-6">
                                                    <div className="form-group">
                                                        <label>Active:</label>
                                                        <div className="form-group clearfix">
                                                            <div className="icheck-primary d-inline">
                                                                <input type="checkbox" disabled={"disabled"} id="active" name="active" defaultChecked={"checked"} />
                                                                <label htmlFor="active"> </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-md-12">
                                        <button onClick={this.btnChange} type="button" className="btn btn-primary mr-2">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </>
        );
    }
}

if (document.getElementById('cpanel-system_menu-datatree')) {
    const app = document.getElementById('cpanel-system_menu-datatree');
    ReactDOM.render(<DataTree {...app.dataset}/>, document.getElementById('cpanel-system_menu-datatree'));
}
