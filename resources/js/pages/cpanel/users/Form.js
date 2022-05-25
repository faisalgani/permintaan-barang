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
            first_name:{
                value: "",
                valid: true,
                message: "",
            },
            email:{
                value: "",
                valid: true,
                message: "",
            },
            password:{
                value: "",
                placeholder: "",
                valid: true,
                message: "",
            },
            re_password:{
                value: "",
                valid: true,
                message: "",
            },
            username: "",
            last_name: "",
            address: "",
            phone: "",
            birthdate: "",
        }
        this.btnSave = this.btnSave.bind(this);
        this.changeName = this.changeName.bind(this);
        this.changeEmail = this.changeEmail.bind(this);
        this.btnDelete = this.btnDelete.bind(this);
        this.changePassword = this.changePassword.bind(this);
        this.changeRePassword = this.changeRePassword.bind(this);
    }

    async changePassword(e){
        await this.setState({
            password: {
                value: e.target.value,
                valid: true,
                message: "",
            }, 
        });
    }

    async changeRePassword(e){
        if($("#password").val() !== $("#re_password").val()){
            await this.setState({
                re_password: {
                    value: e.target.value,
                    valid: false,
                    message: "Retype password not same with pasword",
                }, 
            });
        }else{
            await this.setState({
                re_password: {
                    value: e.target.value,
                    valid: true,
                    message: "",
                }, 
            });
        }
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
                            window.location.href = $this.state.url+"/admin/users";
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
                this.state.url+'/api/v1/users/create', 
                this.state.header, 
                await encryptParameter(await this.getParams()));
            
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
                    toastr.info(result.message);
                    setTimeout(() => {
                        window.location.href = $this.state.url+"/admin/users";
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
                this.state.url+'/api/v1/users/update', 
                this.state.header, 
                await encryptParameter(await this.getParams()));
            
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
                    toastr.info(result.message);
                    setTimeout(() => {
                        window.location.href = $this.state.url+"/admin/users";
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
        obj['first_name'] = $("#first_name").val();
        obj['last_name'] = $("#last_name").val();
        obj['address'] = $("#address").val();
        obj['phone'] = $("#phone").val();
        obj['email'] = $("#email").val();
        obj['username'] = $("#username").val();
        obj['password'] = $("#password").val();
        obj['re_password'] = $("#re_password").val();
        var birthdate = $("#birthdate").val().split("/");
        obj['birthdate'] = birthdate[2]+"-"+birthdate[1]+"-"+birthdate[0];
        obj['gender'] = $("input[name=gender]:checked").val();
        return obj;
    }

    async componentDidMount() {
        var $this = this;
        //Date picker
        var defaultDate = new Date();
        if(this.state.parameter.birthdate !== ""){
            defaultDate = new Date(this.state.parameter.birthdate);
        }

        $('#reservationdate').datetimepicker({
            format: 'D/M/Y',
            defaultDate:defaultDate
        });

        if(this.state.parameter.first_name !== ""){
            this.setState({
                first_name: {
                    value: this.state.parameter.first_name,
                    valid: true,
                    message: "",
                }, 
            })
        }

        if(this.state.parameter.email !== ""){
            this.setState({
                email: {
                    value: this.state.parameter.email,
                    valid: true,
                    message: "",
                }, 
            })
        }

        if(this.state.parameter.phone !== ""){
            this.setState({
                phone: this.state.parameter.phone, 
            })
        }

        if(this.state.parameter.last_name !== ""){
            this.setState({
                last_name: this.state.parameter.last_name, 
            })
        }

        if(this.state.parameter.address !== ""){
            this.setState({
                address: this.state.parameter.address, 
            })
        }

        if(this.state.parameter.username !== ""){
            this.setState({
                username: this.state.parameter.username, 
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

        if(this.state.process == "update"){
            this.setState({
                password: {
                    placeholder: "Mohon di isi, jika ingin merubah password",
                    valid: true,
                    message: "",
                    value: "",
                }, 
            })
        }

        var radios = $('input:radio[name=gender]');
        if(this.state.parameter.gender == true) {
            radios.filter('[value=true]').prop('checked', true);
        }else{
            radios.filter('[value=false]').prop('checked', true);
        }
    }
    
    async phoneInput(e){
        const re = /^[0-9\b]+$/;
    
        // if value is not blank, then test the regex
            console.log(re.test(e.target.value));
        if (e.target.value !="" && re.test(e.target.value) === true) {
            this.setState({phone: e.target.value})
        }
    }

    render() {
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
                                        <label>Username</label>
                                        <input type="text" defaultValue={this.state.username} placeholder="Jika kosong akan menggunakan email" className={"form-control"} id="username" name="username" />
                                    </div>
                                </div>
                                <div className="col-md-3">
                                    <div className="form-group">
                                        <label>Password *</label>
                                        <input type="password" placeholder={this.state.password.placeholder} 
                                        defaultValue={this.state.password.value} 
                                        onChange={this.changePassword} 
                                        className={this.state.password.valid == true ? "form-control":"form-control is-invalid"} id="password" name="password" />
                                        <span className="error invalid-feedback">{this.state.password.message}</span>
                                    </div>
                                </div>
                                <div className="col-md-3">
                                    <div className="form-group">
                                        <label>Re Password</label>
                                        <input type="password" defaultValue={this.state.re_password.value} onChange={this.changeRePassword} className={this.state.re_password.valid == true ? "form-control":"form-control is-invalid"} id="re_password" name="re_password" />
                                        <span className="error invalid-feedback">{this.state.re_password.message}</span>
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
                                        <label>First name *</label>
                                        <input type="text" defaultValue={this.state.first_name.value} onChange={this.changeName} className={this.state.first_name.valid == true ? "form-control":"form-control is-invalid"} id="first_name" name="first_name" />
                                        <span className="error invalid-feedback">{this.state.first_name.message}</span>
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label>Last name</label>
                                        <input type="text" defaultValue={this.state.last_name}  className="form-control" id="last_name" name="last_name" />
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
                                        <label>Phone</label>
                                        <input type="number" pattern="[0-9]*" defaultValue={this.state.phone} className="form-control" id="phone" name="phone" />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label>Email *</label>
                                        <input type="text" defaultValue={this.state.email.value}  onChange={this.changeEmail} className={this.state.email.valid == true ? "form-control":"form-control is-invalid"} id="email" name="email" />
                                        <span className="error invalid-feedback">{this.state.email.message}</span>
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
                                        <label>Birth Date</label>
                                        <div className="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" className="form-control datetimepicker-input" id="birthdate" name="birthdate" data-target="#reservationdate" />
                                            <div className="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div className="input-group-text"><i className="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label>Gender</label>
                                        <div className="form-group clearfix">
                                            <div className="icheck-primary d-inline">
                                                <input type="radio" id="male" name="gender" defaultChecked="checked" value={true} />
                                                <label htmlFor="male">
                                                    Male
                                                </label>
                                            </div> 
                                            <div className="icheck-primary d-inline">
                                                <input type="radio" id="female" name="gender" value={false} />
                                                <label htmlFor="female">
                                                    Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-12">
                            <div className="form-group">
                                <label>Address</label>
                                <textarea className="form-control" id="address" name="address" defaultValue={this.state.address} ></textarea>
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

if (document.getElementById('cpanel-users-form')) {
    const app = document.getElementById('cpanel-users-form');
    ReactDOM.render(<Form {...app.dataset}/>, document.getElementById('cpanel-users-form'));
}
