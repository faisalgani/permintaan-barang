import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {encryptParameter} from '../../../service/ServiceParams';
import * as ExternalAPI from '../../../service/ExternalAPI';
import { v4 as uuidv4 } from 'uuid';

export default class DataGrid extends Component {
    constructor(props) {
        super(props);
        this.state  = {
            showLoading: false,
            disableBtn: false,
            url: props.url,
            id_user: props.id_user,
            active: "",
            pages: 0,
            total: 0,
            projectType: [],
            dataDept: [],
            dataSelect: [],
            idUserDept: "",
            limitChar: 100, 
            loading: false,
            datatable: {},
            header          : {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                "Access-Control-Allow-Origin": "*",
                'X-CSRF-TOKEN': props.token,
            },
            email: "",
            first_name: "",
            last_name: "",
        }
        //this.btnAdd = this.btnAdd.bind(this);
        //this.btnSave = this.btnSave.bind(this);
    }

    async changeStatus(e){
        await this.setState({
            loading: true, 
        });
    }

    // async btnRemove(i, e){
    //     var params = [];
    //     var paramsDelete = {};
    //     var $this = this;

    //     await $('[data-repeater-item="true"]').each(async function(e){
    //         await params.push({
    //             id: $(this).find('[id="id_dept"]').val(),
    //             selected: 1,
    //         });
    //         if(i == e){
    //             paramsDelete.id_dept = $(this).find('[id="id_dept"]').val();
    //             paramsDelete.id_user = $this.state.idUserDept;
    //         }
    //     });
        
    //     await this.setState({
    //         dataSelect: params,
    //     });
    //     let dataSelect = [...this.state.dataSelect];
    //     await dataSelect.splice(i,1);
    //     await this.setState({ dataSelect });
    // }

    // async btnAdd(e){
    //     var tmpDataSelect = this.state.dataSelect;
    //     await tmpDataSelect.push({
    //         id: "",
    //         selected: 0,
    //     });

    //     this.setState({
    //         dataSelect: tmpDataSelect,
    //     });
    // }

    // async processCreate(id_dept, id_user){
    //     var $this = this;
    //     return new Promise(async function(resolve) {
    //         let result = await ExternalAPI.post(
    //             $this.state.url+'/api/v1/member_dept/create', 
    //             $this.state.header, 
    //             await encryptParameter({
    //                 id: uuidv4(),
    //                 id_dept: id_dept,
    //                 id_user: id_user,
    //             }));
        
    //         if(typeof(result.code) !== "undefined"){
    //             if(result.code == 200){
	// 				resolve();
    //             }
    //         }
    //     });
    // }

    // async btnSave(){
    //     var $this = this;
    //     var params = [];
    //     let result = await ExternalAPI.post(
    //         this.state.url+'/api/v1/member_dept/deleteByGroup', 
    //         this.state.header, 
    //         await encryptParameter({
    //             id_user: this.state.idUserDept
    //         })
    //     );
        
    //     await $('[data-repeater-item="true"]').each(async function(e){
    //         await params.push({
    //             id_user: $this.state.idUserDept,
    //             id_dept: $(this).find('[id="id_dept"]').val(),
    //         });
    //     });
        
    //     if(typeof(result.code) !== "undefined"){
    //         if(result.code == 200){
    //             for (let index = 0; index < params.length; index++) {
    //                 if(params[index].id_dept !== ""){
    //                     await this.processCreate(params[index].id_dept, params[index].id_user);
    //                 }
    //             }
    //         }else{
    //             toastr.error(result.message);
    //         }
    //     }
    //     await toastr.info("Success saving list");
    // }

    async getParams(){
        var obj = {}
        obj['page'] = this.state.page;
        obj['perpage'] = this.state.perpage;
        return obj;
    }

    async componentDidMount() {
        var $this = this;
        await this.setState({
            datatable: await $('#dataPermintaanBarang').DataTable({
                "processing": true,
                "serverSide": true,
                "scrollX"   : true,
                "scrollY"   : true,
                "ajax" 		: this.state.url+"/api/v1/permintaan_barang/read",
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', "row-"+aData.id);
                },
                "columns": [
                   
                    { 
                        "data": "no_transaksi",
                        "width": "20%",
                    },  
                    { 
                        "data": "tgl_transaksi",
                        "width": "20%",
                    },   { 
                        "data": "transaksi_to_customer.nama",
                        "width": "20%",
                    },       
                    // {
                    //     "data": "id",
                    //     "width": "15%",
                    //     "render": function (data, type, row) {
                    //         return '<div align="center">'+
                    //         '<div class="btn-group" role="group">'+
                    //         '<a data-toggle="tooltip" data-placement="bottom" title="Kelola" href="'+$this.state.url+'/admin/permintaan_barang/formDetail/'+row.id+'" class="btn btn btn-default btn-sm"><i class="far fa-edit"></i></a>'+
                    //         '<button class="btn btn-default btn-sm" data-name="delete-permintaan" data-id="'+row.id+'"><i class="fa fa-trash-alt"></i></button>'+
                    //         '</div>'+
                    //         '</div>';
                    //     }
                    // }
                ],
            }),
        });
        
        $('#dataPermintaanBarang tbody').on( 'click', 'button', async function (e) {
            if($(this)[0].dataset.name == "delete-permintaan"){
                await Swal.fire({
                      title: 'Yakin untuk menghapus?',
                      showCancelButton: true,
                      confirmButtonText: `Hapus`,
                      cancelButtonText: `Batal`,
                    }).then(async (result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let result = await ExternalAPI.post(
                            $this.state.url+'/api/v1/permintaan_barang/delete', 
                            $this.state.header, 
                            await encryptParameter({
                                id: $(this).data().id,
                            }));
                        if(typeof(result.code) !== 'undefined'){
                            if(result.code == 200){
                                toastr.info(result.message);
                                $this.state.datatable.ajax.reload();
                            }else{
                                toastr.error(result.message);
                            }
                        }
                        
                    }
                });
            }
        } );
    }

    render() {
        const {dataSelect, dataDept} = this.state;
        return (
            <>
                {/* <div className="modal fade" id="modal-default">
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Member departement</h4>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <form id="FormModal">
                            {dataSelect.map((item, index) => {
                                return (
                                    <div className="row mb-3" key={index} data-repeater-item="true">
                                        <div className="col-10">
                                            <select onChange={this.changeDept} className={"form-control"} id="id_dept" name="id_dept">
                                                <option key={0} value={""}>---</option>
                                                {dataDept.map((itemData) => {
                                                    if(item.selected == 1 && item.id == itemData.id){
                                                        return <option key={itemData.id} selected value={itemData.id}>{itemData.name}</option>
                                                    }else{
                                                        return <option key={itemData.id} value={itemData.id}>{itemData.name}</option>
                                                    }
                                                })}
                                            </select>
                                        </div>
                                        <div className="col-2">
                                            <button type="button" onClick={this.btnRemove.bind(this, index)} className="btn btn-danger">X</button>
                                        </div>
                                    </div>
                                );
                            })}
                            <div className="row">
                                <div className="col-12">
                                    <button onClick={this.btnAdd} type="button" className="btn btn-primary btn-block">Add member</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div className="modal-footer justify-content-between">
                        <button type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" onClick={this.btnSave} className="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
                </div> */}
                <table id="dataPermintaanBarang" width="100%" className="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Pemesan</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </>
        );
    }
}

if (document.getElementById('cpanel-permintaan-barang-datagrid')) {
    const app = document.getElementById('cpanel-permintaan-barang-datagrid');
    ReactDOM.render(<DataGrid {...app.dataset}/>, document.getElementById('cpanel-permintaan-barang-datagrid'));
}
