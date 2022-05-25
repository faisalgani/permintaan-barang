import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {encryptParameter} from '../../service/ServiceParams';
import * as ExternalAPI from '../../service/ExternalAPI';
import { v4 as uuidv4 } from 'uuid';

export default class LoginForm extends Component {
    constructor(props) {
        super(props);
        this.state  = {
            showLoadingLogin: false,
            disableBtnLogin: false,
            showLoadingDelete: false,
            disableBtnDelete: false,
            process: props.process,
            url: props.url,
            id: "",
            active: "",
            pages: 0,
            total: 0,
            projectType: [],
            infoError: false,
            infoSuccess: false,
            message: "",
            header          : {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                "Access-Control-Allow-Origin": "*",
                'X-CSRF-TOKEN': props.token,
            },
            username: {
                valid: true,
                value:"",
                message: "",
            },
            password: {
                valid: true,
                value:"",
                message: "",
            }
        }
        this.btnLogin = this.btnLogin.bind(this);
    }

    async btnLogin(){
        await this.setState({
            showLoadingLogin: true,
            disableBtnLogin: true,
        });
        var $this = this;
        let result = await ExternalAPI.post(
            this.state.url+'/api/v1/auth/login', 
            this.state.header, 
            await encryptParameter(await this.getParams())
        );
                
        if(typeof(result.code) !== 'undefined'){
            if(result.code == 200){
                window.location.href = this.state.url+"/admin";
            }else{
                this.setState({
                    infoError: true,
                    message: result.message,
                })
            }
        }

        if($("#remember").is(":checked") === true){
            localStorage.setItem("remember", JSON.stringify(await this.getParams()));
        }else{
            localStorage.setItem("remember", JSON.stringify({}));
        }
        
        await this.setState({
            showLoadingLogin: false,
            disableBtnLogin: false,
        });
    }

    async getParams(){
        var obj = {}
        obj['username'] = $("#username").val();
        obj['password'] = $("#password").val();
        return obj;
    }

    async componentDidMount() {
        var $this = this;
        if(JSON.parse(localStorage.getItem("remember")) !== null){
            var tmpRemember = JSON.parse(localStorage.getItem("remember"));
            if(typeof(tmpRemember.username) !== 'undefined' && typeof(tmpRemember.password) !== 'undefined'){
                await this.setState({
                    username: {
                        valid: true,
                        value: tmpRemember.username,
                        message: "",
                    },
                    password: {
                        valid: true,
                        value: tmpRemember.password,
                        message: "",
                    }
                });
                await $("#remember").prop("checked", Boolean(Number(true)));
            }
        }
    }

    render() {
        return (
            <>
                <form method="post">
                    <div className="input-group mb-3">
                        <div className="alert alert-danger alert-dismissible"  style={{display: this.state.infoError ? '' : 'none' }}>
                            {this.state.message}
                        </div>
                    </div>
                    <div className="input-group mb-3">
                        <input type="text" id="username" name="username" 
                         defaultValue={this.state.username.value} 
                        className={this.state.username.valid == true ? "form-control":"form-control is-invalid"} placeholder="Email or username" />
                        <div className="input-group-append">
                            <div className="input-group-text">
                                <span className="fas fa-envelope"></span>
                            </div>
                        </div>
                        <span className="error invalid-feedback">{this.state.username.message}</span>
                    </div>
                    <div className="input-group mb-3">
                        <input type="password" id="password" name="password" 
                         defaultValue={this.state.password.value} 
                        className={this.state.password.valid == true ? "form-control":"form-control is-invalid"} placeholder="Password" />
                        <div className="input-group-append">
                        <div className="input-group-text">
                            <span className="fas fa-lock"></span>
                        </div>
                        </div>
                        <span className="error invalid-feedback">{this.state.password.message}</span>
                    </div>
                    <div className="row">
                        <div className="col-8">
                        <div className="icheck-primary">
                            <input type="checkbox" id="remember" />
                            <label htmlFor="remember">
                            Remember Me
                            </label>
                        </div>
                        </div>
                        <div className="col-4">
                        <button onClick={this.btnLogin} type="button" className="btn btn-primary btn-block">
                            <span className="fa fa-spinner fa-spin" style={{display: this.state.showLoadingLogin ? '' : 'none' }}></span>
                        Sign In</button>
                        </div>
                    </div>
                </form>
            </>
        );
    }
}

if (document.getElementById('cpanel-login-form')) {
    const app = document.getElementById('cpanel-login-form');
    ReactDOM.render(<LoginForm {...app.dataset}/>, document.getElementById('cpanel-login-form'));
}
