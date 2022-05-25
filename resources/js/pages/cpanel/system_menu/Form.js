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
            disableBtnSave: false,
            showLoadingDelete: false,
            disableBtnDelete: false,
            parameter: JSON.parse(props.parameter),
            process: props.process,
            url: props.url,
            id: "",
            active: "",
            pages: 0,
            total: 0,
            projectType: [],
            limitChar: 100, 
            loading: false,
            infoError: false,
            infoSuccess: false,
            message: "",
            header          : {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                "Access-Control-Allow-Origin": "*",
                'X-CSRF-TOKEN': props.token,
            },
            menu:{
                value: "",
                valid: true,
                message: "",
            },
            link:{
                value: "",
                valid: true,
                message: "",
            },
            icon: "",
            parent: "",
            parentList: [],
            class: "",
            state: "",
        }
        this.btnSave = this.btnSave.bind(this);
        this.changeName = this.changeName.bind(this);
        this.changeEmail = this.changeEmail.bind(this);
        this.btnDelete = this.btnDelete.bind(this);
    }

    async btnDelete(){
        var $this = this;
        await this.setState({
            showLoadingDelete: true,
            disableBtnDelete: true,
        });

        await Swal.fire({
                title: 'Yakin untuk menghapus?',
                showCancelButton: true,
                confirmButtonText: `Hapus`,
                cancelButtonText: `Batal`,
            }).then(async (result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let result = await ExternalAPI.post(
                    $this.state.url+'/api/v1/system_menu/delete', 
                    $this.state.header, 
                    await encryptParameter({
                        id: $("#id").val(),
                    }));
                if(typeof(result.code) !== 'undefined'){
                    if(result.code == 200){
                        toastr.info(result.message);
                        setTimeout(() => {
                            window.location.href = $this.state.url+"/admin/system_menu";
                        }, 1000);
                    }else{
                        toastr.error(result.message);
                    }
                }
            }
        });

        await this.setState({
            showLoadingDelete: false,
            disableBtnDelete: false,
        });
    }

    async btnSave(){
        var $this = this;
        await this.setState({
            showLoadingSave: true,
            disableBtnSave: true,
        });
        
        if(this.state.process == "create"){
            let result = await ExternalAPI.post(
                this.state.url+'/api/v1/system_menu/create', 
                this.state.header, 
                await encryptParameter(await this.getParams()));
            
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
                    toastr.info(result.message);
                    setTimeout(() => {
                        window.location.href = $this.state.url+"/admin/system_menu";
                    }, 1000);
                }else{
                    if(typeof(result.role) !== "undefined"){
                        if(result.role.length > 0){
                            this.setState({
                                infoError: true,
                                infoSuccess: false,
                                message: result.message
                            });
    
                            result.role.forEach(element => {
                                this.setState({
                                    [element.key]: {
                                        valid: false,
                                        message: element.message
                                    },
                                })
                            });
                        }
                    }
                }
            }
        }else{
            let result = await ExternalAPI.post(
                this.state.url+'/api/v1/system_menu/update', 
                this.state.header, 
                await encryptParameter(await this.getParams()));
            
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
                    toastr.info(result.message);
                    setTimeout(() => {
                        window.location.href = $this.state.url+"/admin/system_menu";
                    }, 1000);
                }else{
                    if(typeof(result.role) !== "undefined"){
                        if(result.role.length > 0){
                            this.setState({
                                infoError: true,
                                infoSuccess: false,
                                message: result.message
                            });
    
                            result.role.forEach(element => {
                                this.setState({
                                    [element.key]: {
                                        valid: false,
                                        message: element.message
                                    },
                                })
                            });
                        }
                    }
                }
            }
        }
        await this.setState({
            showLoadingSave: false,
            disableBtnSave: false,
        });
    }

    async changeStatus(e){
        await this.setState({
            loading: true, 
        });
    }

    async changeName(e){
        await this.setState({
            menu: {
                value: e.target.value,
                valid: true,
                message: "",
            }, 
        });
    }

    async changeEmail(e){
        await this.setState({
            link: {
                value: e.target.value,
                valid: true,
                message: "",
            }, 
        });
    }

    async getParams(){
        var obj = {}
        obj['id'] = $("#id").val();
        obj['menu'] = $("#menu").val();
        obj['link'] = $("#link").val();
        obj['icon'] = $("#icon").val();
        obj['parent'] = $("#parent").val();
        obj['class'] = $("#class").val();
        obj['state'] = $("#state").val();
        obj['active'] = $("#active").is(":checked");
        return obj;
    }

    async componentDidMount() {
        var $this = this;
        //Date picker

        var parameter = await encryptParameter({
            id: "",
        });
        var result = await ExternalAPI.get(this.state.url+'/api/v1/system_menu/store', this.state.header); 
        if(typeof(result.code) !== "undefined"){
            if(result.code == 200){
                var data = [];
                result.data.forEach(element => {
                    data.push({
                        id: element.id,
                        text: element.menu,
                    });
                });
                await this.setState({
                    parentList: data
                });
            }
        }

        if(this.state.parameter.menu !== ""){
            this.setState({
                menu: {
                    value: this.state.parameter.menu,
                    valid: true,
                    message: "",
                }, 
            })
        }

        if(this.state.parameter.link !== ""){
            this.setState({
                link: {
                    value: this.state.parameter.link,
                    valid: true,
                    message: "",
                }, 
            })
        }

        if(this.state.parameter.icon !== ""){
            this.setState({
                icon: this.state.parameter.icon, 
            })
        }

        if(this.state.parameter.parent !== ""){
            this.setState({
                parent: this.state.parameter.parent, 
            })
        }

        if(this.state.parameter.class !== ""){
            this.setState({
                class: this.state.parameter.class, 
            })
        }


        if(this.state.parameter.state !== ""){
            this.setState({
                state: this.state.parameter.state, 
            })
        }

        if(this.state.parameter.id !== ""){
            this.setState({
                id: this.state.parameter.id, 
            })
        }else{
            this.setState({
                id: uuidv4(), 
            })
        }

        await $("#active").prop("checked", Boolean(Number(this.state.parameter.active)));
    }

    render() {
        const {parentList} = this.state;
        return (
            <>
                <div className="card-body">
                    <div className="alert alert-danger alert-dismissible"  style={{display: this.state.infoError ? '' : 'none' }}>
                        <button type="button" className="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i className="icon fas fa-ban"></i> Alert!</h5>
                        {this.state.message}
                    </div>

                    <div className="alert alert-info alert-dismissible"  style={{display: this.state.infoSuccess ? '' : 'none' }}>
                        <button type="button" className="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i className="icon fas fa-info"></i> Info</h5>
                        {this.state.message}
                    </div>

                    <input type="hidden" id="id" name="id" defaultValue={this.state.id} />
                    <div className="row">
                        <div className="col-md-12">
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label>Menu *</label>
                                        <input type="text" defaultValue={this.state.menu.value} onChange={this.changeName} className={this.state.menu.valid == true ? "form-control":"form-control is-invalid"} id="menu" name="menu" />
                                        <span className="error invalid-feedback">{this.state.menu.message}</span>
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label>Link *</label>
                                        <input type="text" defaultValue={this.state.link.value}  onChange={this.changeEmail} className={this.state.link.valid == true ? "form-control":"form-control is-invalid"} id="link" name="link" />
                                        <span className="error invalid-feedback">{this.state.link.message}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-12">
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label>Icon</label>
                                        <input type="text" defaultValue={this.state.icon} className="form-control" id="icon" name="icon" />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label>Parent</label>
                                        <select id="parent" name="parent" className={'form-control'}>
                                            <option key={0} value={""}>---</option>
                                            {parentList.map((item) => {
                                                if(this.state.parent == item.id){
                                                    return <option key={item.id} selected value={item.id}>{item.text}</option>
                                                }else{
                                                    return <option key={item.id} value={item.id}>{item.text}</option>
                                                }
                                            })}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-12">
                            <div className="row">
                                <div className="col-md-4">
                                    <div className="form-group">
                                        <label>Class</label>
                                        <input type="text" defaultValue={this.state.class} className="form-control" id="class" name="class" />
                                    </div>
                                </div>
                                <div className="col-md-4">
                                    <div className="form-group">
                                        <label>State</label>
                                        <input type="text" defaultValue={this.state.state} className="form-control" id="state" name="state" />
                                    </div>
                                </div>
                                <div className="col-md-4">
                                    <div className="form-group">
                                        <label>Active</label>
                                        <div className="form-group clearfix">
                                            <div className="icheck-primary d-inline">
                                                <input type="checkbox" id="active" name="active" defaultChecked={"checked"} />
                                                <label htmlFor="active"> </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="card-footer">
                    <button type="button" onClick={this.btnSave} className="btn btn-primary mr-2" disabled={ this.state.disableBtnSave===false ? "" : "disabled" }>
                        <span style={{display: this.state.showLoadingSave ? '' : 'none' }} className="fa fa-spinner fa-pulse fa-sx fa-fw"></span>Save
                    </button>
                    <button onClick={this.btnDelete} disabled={ this.state.disableBtnDelete===false ? "" : "disabled" } style={{display: this.state.process=="create" ? 'none' : '' }} type="button" className="btn btn-danger">
                    <span style={{display: this.state.showLoadingDelete ? '' : 'none' }} className="fa fa-spinner fa-pulse fa-sx fa-fw"></span>Delete
                    </button>
                </div>
            </>
        );
    }
}

if (document.getElementById('cpanel-system_menu-form')) {
    const app = document.getElementById('cpanel-system_menu-form');
    ReactDOM.render(<Form {...app.dataset}/>, document.getElementById('cpanel-system_menu-form'));
}
