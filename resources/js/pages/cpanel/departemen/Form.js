import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {encryptParameter} from '../../../service/ServiceParams';
import * as ExternalAPI from '../../../service/ExternalAPI';
import ReactCrop from 'react-image-crop';
import 'react-image-crop/dist/ReactCrop.css';
import { v4 as uuidv4 } from 'uuid';
//import noImage from './no-image.png';
import axios from 'axios';

export default class Form extends Component {
    constructor(props) {
        super(props);
        // const current = new Date();
        // const date = `${current.getDate()}/${current.getMonth()+1}/${current.getFullYear()}`;
        this.state  = {
            
            time_now : new Date().toLocaleTimeString(),
            date_now : new Date().toLocaleDateString(),
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
            iconMap: L.icon({
                iconSize: [25, 41],
                iconAnchor: [10, 41],
                popupAnchor: [2, -40],
                iconUrl: "https://unpkg.com/leaflet@1.7/dist/images/marker-icon.png",
                shadowUrl: "https://unpkg.com/leaflet@1.7/dist/images/marker-shadow.png"
            }),
            header          : {
                'Content-Type': 'application/x-www-form-urlencoded',
                "Access-Control-Allow-Origin": "*",
                'X-CSRF-TOKEN': props.token,
            },
    
            nama_departemen:"",
            link:{
                value: "",
                valid: true,
                message: "",
            },
            state: "",
           
            change_image:false,
            src: null,
            crop: {
              unit: '%',
              width: 30,
              aspect: 21 / 9,
            },
            imageRef: "", 
            image: "",
        }
        this.btnSave = this.btnSave.bind(this);
        this.btnChangeDraft = this.btnChangeDraft.bind(this);
        //this.changeName = this.changeName.bind(this);
       // this.changeEmail = this.changeEmail.bind(this);
        this.btnDelete = this.btnDelete.bind(this);
        //this.btnAddAgenda = this.btnAddAgenda.bind(this);
        //this.btnAddSocial = this.btnAddSocial.bind(this);
       // this.btnAddPhone = this.btnAddPhone.bind(this);
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
                    $this.state.url+'/api/v1/departemen/delete', 
                    $this.state.header, 
                    await encryptParameter({
                        id: $("#id").val(),
                    }));
                if(typeof(result.code) !== 'undefined'){
                    if(result.code == 200){
                        toastr.info(result.message);
                        setTimeout(() => {
                            window.location.href = $this.state.url+"/admin/departemen";
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


    async btnAddAgenda(e){
        var tmpAgenda = this.state.agenda;
        await tmpAgenda.push({
            text: "",
            status: false,
        });

        this.setState({
            agenda: tmpAgenda,
        });
        
        await $('[data-repeater-agenda="true"]').each(async function(e){
            $(this).find('[name="reservation"]').daterangepicker();
        });
    }

    async btnRemoveAgenda(i, e){
        var params = [];
        var $this = this;

        await $('[data-repeater-agenda="true"]').each(async function(e){
            await params.push({
                reservation: $(this).find('[name="reservation"]').val(),
                description: $(this).find('[name="description"]').val(),
            });
        });
        
        await this.setState({
            agenda: params,
        });
        let agenda = [...this.state.agenda];
        await agenda.splice(i,1);
        await this.setState({ agenda });
    }

    async btnAddSocial(e){
        var tmpSocial = this.state.social_media;
        await tmpSocial.push({
            social_media: "",
            link: "",
        });

        this.setState({
            social_media: tmpSocial,
        });
    }


    async btnRemoveSocial(i, e){
        var params = [];
        var $this = this;

        await $('[data-repeater-social="true"]').each(async function(e){
            await params.push({
                social: $(this).find('[name="social"]').val(),
                link: $(this).find('[name="link"]').val(),
            });
        });
        
        await this.setState({
            social_media: params,
        });
        let social_media = [...this.state.social_media];
        await social_media.splice(i,1);
        await this.setState({ social_media });
    }

    async btnAddPhone(e){
        var tmpPhone = this.state.phone;
        await tmpPhone.push({
            label: "phone",
            value: "",
        });

        this.setState({
            phone: tmpPhone,
        });
    }

    async btnRemovePhone(i, e){
        var params = [];
        var $this = this;

        await $('[data-repeater-phone="true"]').each(async function(e){
            await params.push({
                phone: $(this).find('[name="phone"]').val(),
            });
        });
        
        await this.setState({
            phone: params,
        });
        let phone = [...this.state.phone];
        await phone.splice(i,1);
        await this.setState({ phone });
    }

    async getParams(){
        var obj = {}
        obj['nama_departemen'] = $("#nama_departemen").val();
        return obj;
    }

    async btnSave(){
        var $this = this;
        await this.setState({
            showLoadingSave: true,
            disableBtnSave: true,
        });
       // console.log($("#id").val());
        if(this.state.process == "create"){
            let result = await ExternalAPI.post(
                this.state.url+'/api/v1/departemen/create', 
                this.state.header, 
                await encryptParameter(await this.getParams()));
            
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
                    toastr.info(result.message);
                    setTimeout(() => {
                        window.location.href = $this.state.url+"/admin/departemen";
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
                this.state.url+'/api/v1/departemen/update', 
                this.state.header, 
                await encryptParameter(await this.getParams()));
            
            if(typeof(result.code) !== "undefined"){
                if(result.code == 200){
                    toastr.info(result.message);
                    setTimeout(() => {
                        window.location.href = $this.state.url+"/admin/departemen";
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
            change_image:false,
            showLoadingSave: false,
            disableBtnSave: false,
        });
    }

    async btnChangeDraft(){
        var $this = this;
        await this.setState({
            showLoadingSave: true,
            disableBtnSave: true,
        });
        
        let result = await ExternalAPI.post(
            this.state.url+'/api/v1/departemen/update', 
            this.state.header, 
            await encryptParameter(await {
                id: $("#id").val(),
                state: 'draft',
            }));
        
        if(typeof(result.code) !== "undefined"){
            if(result.code == 200){
                toastr.info(result.message);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }else{
            }
        }

        await this.setState({
            change_image:false,
            showLoadingSave: false,
            disableBtnSave: false,
        });
    }

    async changeStatus(e){
        await this.setState({
            loading: true, 
        });
    }

    

    

    async componentDidMount() {
        var $this = this;
        let result = await ExternalAPI.get(
            this.state.url+'/api/v1/departemen/store/', 
            this.state.header);
        
        if(typeof(result.code) !== 'undefined'){
            if(result.code == 200){
                this.setState({
                    dataRoomType: result.data,
                });
            }
        }

        console.log(this.state.parameter);
        if(this.state.parameter.id !== ""){
            this.setState({
                id: this.state.parameter.id, 
            })
        }

        if(this.state.parameter.nama_departemen !== ""){
            this.setState({
                nama_departemen: this.state.parameter.nama_departemen, 
            });
            $("#nama_departemen").val(this.state.parameter.nama_departemen);
        }

        $('.summernote').summernote({
            tabsize: 2,
            height: 400,
        });
    }

    async initialMaps(map, leaflet, showPop){
        var $this = this;
        // Init Leaflet Map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(leaflet);
        // Set Geocoding
        var geocodeService;
        if (typeof L.esri.Geocoding === 'undefined') {
            geocodeService = L.esri.geocodeService();
        } else {
            geocodeService = L.esri.Geocoding.geocodeService();
        }

        // Define Marker Layer
        var markerLayer = L.layerGroup().addTo(leaflet);
        var search_control = L.esri.Geocoding.geosearch().addTo(leaflet);
        var results = L.layerGroup().addTo(leaflet);
        search_control.on('results', function(data){
            results.clearLayers();
            for(var i = data.results.length -1; i>=0; i--){
                results.addLayer(L.marker(data.results[i].latlng));
            }
            geocodeService.reverse().latlng(data.latlng).run(function (error, result) {
            if (error) {
                return;
            }
            markerLayer.clearLayers(); // remove this line to allow multi-markers on click
            L.marker(result.latlng, { icon: $this.state.iconMap }).addTo(markerLayer).bindPopup(result.address.Match_addr, { closeButton: false }).openPopup();
                map.val(`${JSON.stringify(result.latlng)}`);
            });
        });
        if(showPop === true){
            // bind marker with popup
            geocodeService.reverse().latlng(leaflet._lastCenter).run(function (error, result) {
            if (error) {
                return;
            }
            markerLayer.clearLayers(); // remove this line to allow multi-markers on click
            L.marker(result.latlng, { icon: $this.state.iconMap }).addTo(markerLayer).openPopup();
                map.val(`${JSON.stringify(result.latlng)}`);
            });
        }
        leaflet.on('click', function (e) {
            geocodeService.reverse().latlng(e.latlng).run(function (error, result) {
            if (error) {
                return;
            }
            markerLayer.clearLayers(); // remove this line to allow multi-markers on click
            L.marker(result.latlng, { icon: $this.state.iconMap }).addTo(markerLayer).bindPopup(result.address.Match_addr, { closeButton: false }).openPopup();
                map.val(`${JSON.stringify(result.latlng)}`);
            });
        });
    }
    
    async onSelectFile(e){
        var $this = this;
        if (e.target.files && e.target.files.length > 0) {
        const reader = new FileReader();
        reader.addEventListener('load', () => {
                $this.setState({ src: reader.result })
            }
        );
        reader.readAsDataURL(e.target.files[0]);
        }
    };

    // If you setState the crop in here you should return false.
    onImageLoaded(image){
        this.setState({
            imageRef: image,
        })
    };
  
    onCropComplete(crop){
        this.setState({crop: crop});
        // this.makeClientCrop(crop);
    };
  
    onCropChange(crop, percentCrop){
        // You could also use percentCrop:
        // this.setState({ crop: percentCrop });
        this.setState({ crop });
    };

    async makeClientCrop(crop) {
        if (this.state.imageRef && crop.width && crop.height) {
            const croppedImageUrl = await this.getCroppedImg(
                this.state.imageRef,
                crop,
                'newFile.jpeg'
            );
            this.setState({ croppedImageUrl });
        }
    }

    async getFileFromUrl(url, name, defaultType = 'image/jpeg'){
        const response = await fetch(url);
        const data = await response.blob();
        return new File([data], name, {
          type: response.headers.get('content-type') || defaultType,
        });
    }

    async makeClientCropManual() {
        if (this.state.imageRef && this.state.crop.width && this.state.crop.height) {
            const croppedImageUrl = await this.getCroppedImg(
                this.state.imageRef,
                this.state.crop,
                'newFile.jpeg'
            );
            this.setState({ croppedImageUrl });
        }

        const formData = new FormData();
        formData.append(
            "image",
            $("#cover_room")[0].files[0]
        );
        // formData.append(
        //     "image_crop",
        //     new File([this.state.croppedImageUrl], "filename.jpg", {type:"image/png", lastModified:new Date().getTime()})
        // );
        formData.append(
            "image_crop",
            await this.getFileFromUrl(this.state.croppedImageUrl, 'filename.jpg')
        );
        formData.append(
            "id",
            $("#id").val()
        );
        formData.append(
            "crop",
            JSON.stringify(this.state.crop)
        );
        
        let result = await axios.post(this.state.url+'/api/v1/room/upload_image', formData, this.state.header);
        result = result.data;
        if(typeof(result.code) !== "undefined"){
            if(result.code == 200){
                this.setState({
                    image: result.image,
                    change_image: true,
                })
            }
        }
    }
    
    getCroppedImg(image, crop, fileName) {
        var $this = this;
        const canvas = document.createElement('canvas');
        const scaleX = image.naturalWidth / image.width;
        const scaleY = image.naturalHeight / image.height;
        canvas.width = crop.width;
        canvas.height = crop.height;
        const ctx = canvas.getContext('2d');

        ctx.drawImage(
            image,
            crop.x * scaleX,
            crop.y * scaleY,
            crop.width * scaleX,
            crop.height * scaleY,
            0,
            0,
            crop.width,
            crop.height
            );

            return new Promise((resolve, reject) => {
                canvas.toBlob(blob => {
                    if (!blob) {
                        //reject(new Error('Canvas is empty'));
                        console.error('Canvas is empty');
                        return;
                    }
                    blob.name = fileName;
                    window.URL.revokeObjectURL(this.fileUrl);
                    this.fileUrl = window.URL.createObjectURL(blob);
                    resolve(this.fileUrl);
                }, 'image/jpeg');
            }
        );
    }

    render() {
        const { crop, croppedImageUrl, src } = this.state;
        const {parentList, agenda, dataSocial, phone,  social_media,dataRoomType} = this.state;
        const position = [51.505, -0.09];
        return (
            <>
                    <div className="modal fade" id="modal-lg">
                        <div className="modal-dialog modal-lg">
                            <div className="modal-content">
                            <div className="modal-header">
                                <h4 className="modal-title">Upload image cover</h4>
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <div className="form-group">
                                    <div>
                                        <input type="file" accept="image/*" onChange={this.onSelectFile.bind(this)} id="cover_room" name="cover_room" />
                                    </div>
                                    {src && (
                                    <ReactCrop
                                        src={src}
                                        crop={crop}
                                        ruleOfThirds
                                        onImageLoaded={this.onImageLoaded.bind(this)}
                                        onComplete={this.onCropComplete.bind(this)}
                                        onChange={this.onCropChange.bind(this)}
                                    />
                                    )}
                                </div>
                            </div>
                            <div className="modal-footer justify-content-between">
                                <button type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" className="btn btn-primary" data-dismiss="modal" onClick={this.makeClientCropManual.bind(this)}>Save changes</button>
                            </div>
                            </div>
                        </div>
                    </div>
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
                                <div className="col-md-8">
                                    <div className="card card-default">
                                        <div className="card-body">
                                            <div className="form-group">
                                                <label>Nama Departemen *</label>
                                                <input type="text" defaultValue={this.state.nama_departemen}  className={"form-control"} id="nama_departemen" name="nama_departemen" />
                                            </div>
                            
                                        </div>
                                        <div className="card-footer">
                                            <button type="button" 
                                            onClick={this.btnSave} 
                                            className="btn btn-primary mr-2" 
                                            style={{display: this.state.parameter.state == "approve" ? 'none' : '' }}
                                            disabled={ this.state.disableBtnSave===false ? "" : "disabled" }>
                                                <span style={{display: this.state.showLoadingSave ? '' : 'none' }} className="fa fa-spinner fa-pulse fa-sx fa-fw"></span>Save
                                            </button>
                                            <button type="button" 
                                            onClick={this.btnChangeDraft} 
                                            className="btn btn-success mr-2" 
                                            style={{display: this.state.parameter.state == "approve" ? '' : 'none' }}
                                            disabled={ this.state.disableBtnSave===false ? "" : "disabled" }>
                                                <span style={{display: this.state.showLoadingSave ? '' : 'none' }} className="fa fa-spinner fa-pulse fa-sx fa-fw"></span>Send to draft
                                            </button>
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

if (document.getElementById('cpanel-departemen-form')) {
    const app = document.getElementById('cpanel-departemen-form');
    ReactDOM.render(<Form {...app.dataset}/>, document.getElementById('cpanel-departemen-form'));
}
