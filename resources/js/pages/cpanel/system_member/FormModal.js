import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {encryptParameter} from '../../../service/ServiceParams';
import * as ExternalAPI from '../../../service/ExternalAPI';
import { v4 as uuidv4 } from 'uuid';

export default class FormModal extends Component {
    constructor(props) {
        super(props);
        this.state  = {
            showLoadingSave: false,
            disableBtnSave: false,
            showLoadingDelete: false,
            disableBtnDelete: false,
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
            group:{
                value: "",
                valid: true,
                message: "",
            },
            email:{
                value: "",
                valid: true,
                message: "",
            },
            last_name: "",
            address: "",
            phone: "",
            birthdate: "",
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
                    $this.state.url+'/api/v1/users/delete', 
                    $this.state.header, 
                    await encryptParameter({
                        id: $("#id").val(),
                    }));
                if(typeof(result.code) !== 'undefined'){
                    if(result.code == 200){
                        toastr.info(result.message);
                        setTimeout(() => {
                            window.location.href = $this.state.url+"/users";
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
        if($("#id").val() == ""){
            $("#id").val(uuidv4());
            let result = await ExternalAPI.post(
                this.state.url+'/api/v1/system_group/create', 
                this.state.header, 
                await encryptParameter(await this.getParams()));
            
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
                    toastr.info(result.message);
                    setTimeout(() => {
                        window.location.href = $this.state.url+"/system_group";
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
                    $("#id").val("");
                }
            }
        }else{
            let result = await ExternalAPI.post(
                this.state.url+'/api/v1/system_group/update', 
                this.state.header, 
                await encryptParameter(await this.getParams()));
            
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
                    toastr.info(result.message);
                    setTimeout(() => {
                        window.location.href = $this.state.url+"/system_group";
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
            first_name: {
                value: e.target.value,
                valid: true,
                message: "",
            }, 
        });
    }

    async changeEmail(e){
        await this.setState({
            email: {
                value: e.target.value,
                valid: true,
                message: "",
            }, 
        });
    }

    async getParams(){
        var obj = {}
        obj['id'] = $("#id").val();
        obj['group'] = $("#group").val();
        obj['active'] = $("#active").is(":checked");
        return obj;
    }

    async componentDidMount() {
        var $this = this;
    }

    render() {
        return (
            <>
                <div className="modal fade" id="exampleModal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div className="modal-dialog" role="document">
                        <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLabel">Form group</h5>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <input type="hidden" id="id" name="id" />
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label>Group *</label>
                                        <input type="text" defaultValue={this.state.group.value} onChange={this.changeName} className={this.state.group.valid == true ? "form-control":"form-control is-invalid"} id="group" name="group" />
                                        <span className="error invalid-feedback">{this.state.group.message}</span>
                                    </div>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="form-group clearfix">
                                    <div className="icheck-primary d-inline">
                                        <input type="checkbox" id="active" name="active" defaultChecked={"checked"} />
                                        <label htmlFor="active">
                                            Active
                                        </label>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" disabled={ this.state.disableBtnSave===false ? "" : "disabled" } onClick={this.btnSave} className="btn btn-primary">
                                <span style={{display: this.state.showLoadingSave ? '' : 'none' }} className="fa fa-spinner fa-pulse fa-sx fa-fw"></span>Save changes
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
            </>
        );
    }
}

if (document.getElementById('cpanel-system_group-form_modal')) {
    const app = document.getElementById('cpanel-system_group-form_modal');
    ReactDOM.render(<FormModal {...app.dataset}/>, document.getElementById('cpanel-system_group-form_modal'));
}
