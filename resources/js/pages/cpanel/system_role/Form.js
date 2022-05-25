import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {encryptParameter} from '../../../service/ServiceParams';
import * as ExternalAPI from '../../../service/ExternalAPI';
import { v4 as uuidv4 } from 'uuid';

export default class Form extends Component {
    constructor(props) {
        super(props);
        this.state  = {
            showLoadingSave: false,
            disableBtnSave: true,
            showLoadingDelete: false,
            disableBtnDelete: false,
            process: props.process,
            url: props.url,
            id: "",
            active: "",
            pages: 0,
            total: 0,
            data: [],
            dataMultiple: [],
            dataSelect: [],
            limitChar: 100, 
            loading: false,
            infoError: false,
            infoSuccess: false,
            message: "",
            duallist: {},
            select2: {},
            header          : {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                "Access-Control-Allow-Origin": "*",
                'X-CSRF-TOKEN': props.token,
            },
        }
        this.changeCmb = this.changeCmb.bind(this);
        this.btnSave = this.btnSave.bind(this);
    }

    async changeCmb(e){
        if(e.target.value !== ""){
            var tmpID = e.target.value;
            await this.setState({
                id: tmpID,
                disableBtnSave: false,
            });
            await this.loadData();
        }else{
            await this.setState({
                disableBtnSave: true,
                dataMultiple: [],
            });
            this.state.duallist.bootstrapDualListbox('refresh', true);
        }
    }

    async loadData(){
        let result = await ExternalAPI.get(
            this.state.url+'/api/v1/system_role/store/'+this.state.id, 
            this.state.header);
        if(typeof(result.code) !== 'undefined'){
            if(result.code == 200){
                var tmpSelected = [];
                await result.data.forEach(element => {
                    tmpSelected.push(element.id);
                });
                await this.setState({
                    dataMultiple: result.data,
                    dataSelect: tmpSelected,
                });
            }
        }
        this.state.duallist.bootstrapDualListbox('refresh', true);
    }

    async processCreate(id_menu, id_group){
        var $this = this;
        return new Promise(async function(resolve) {
            let result = await ExternalAPI.post(
                $this.state.url+'/api/v1/system_role/create', 
                $this.state.header, 
                await encryptParameter({
                    id: uuidv4(),
                    id_menu: id_menu,
                    id_group: id_group,
                }));
        
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
					resolve();
                }
            }
        });
    }
    
    async btnSave(){
        await this.setState({
            showLoadingSave: true,
            disableBtnSave: true,
        });
        let result = await ExternalAPI.post(
            this.state.url+'/api/v1/system_role/deleteByGroup', 
            this.state.header, 
            await encryptParameter({
                id_group: this.state.id
            }));
        
        if(typeof(result.code) !== "undefined"){
            if(result.code == 200){
                var optionLIst = this.state.duallist[0].options;
                for (let index = 0; index < optionLIst.length; index++) {
                    if(optionLIst[index].selected === true){
                        await this.processCreate(optionLIst[index].value, this.state.id);
                    }
                }
            }else{
                toastr.error(result.message);
            }
        }
        await toastr.info("Success saving list");
        await this.loadData();
        await this.setState({
            showLoadingSave: false,
            disableBtnSave: false,
        });
    }

    async getParams(){
        var obj = {}
        obj['id'] = $("#id").val();
        obj['first_name'] = $("#first_name").val();
        obj['last_name'] = $("#last_name").val();
        obj['address'] = $("#address").val();
        obj['phone'] = $("#phone").val();
        obj['email'] = $("#email").val();
        var birthdate = $("#birthdate").val().split("/");
        obj['birthdate'] = birthdate[2]+"-"+birthdate[1]+"-"+birthdate[0];
        obj['gender'] = $("input[name=gender]:checked").val();
        return obj;
    }

    async componentDidMount() {
        var $this = this;
        //Bootstrap Duallistbox

        this.setState({
            duallist: $('.duallistbox').bootstrapDualListbox(), 
            select2: $('.select2').select2(),
        });
        
        let result = await ExternalAPI.get(
            $this.state.url+'/api/v1/system_group/store', 
            $this.state.header);
        
        if(typeof(result.code) !== "undefined"){
            if(result.code == 200){
                await this.setState({
                    data: result.data,
                })
            }
        }
    }

    render() {
        const {data, dataMultiple, dataSelect} = this.state;
        return (
            <>
                <div className="card-header">
                    <div className="card-tools">
                        <button type="button" disabled={ this.state.disableBtnSave===false ? "" : "disabled" } onClick={this.btnSave} className="btn btn-primary">
                            <span style={{display: this.state.showLoadingSave ? '' : 'none' }} className="fa fa-spinner fa-pulse fa-sx fa-fw"></span>
                            <span style={{display: this.state.showLoadingSave ? 'none' : '' }} className="fas fa-save"></span> Simpan
                        </button>
                    </div>
                </div>
                <div className="card-body">
                    <div className="row">
                        <div className="col-12">
                            <div className="form-group">
                            <label>Group</label>
                            <select onChange={this.changeCmb} className="form-control" style={{width:"100%"}}>
                                <option key={0} value={""}>---</option>
                                {data.map((item) => {
                                    return <option key={item.id} value={item.id}>{item.group}</option>
                                })}
                            </select>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-12">
                            <div className="form-group">
                            <label>Daftar menu</label>
                            <select className="duallistbox" multiple="multiple" defaultValue={dataSelect}>
                                {dataMultiple.map((item) => {
                                    return <option key={item.id} value={item.id} selected={item.selected == 1?"selected":""}>{item.menu}</option>
                                })}
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
            </>
        );
    }
}

if (document.getElementById('cpanel-system_role-form')) {
    const app = document.getElementById('cpanel-system_role-form');
    ReactDOM.render(<Form {...app.dataset}/>, document.getElementById('cpanel-system_role-form'));
}
