import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {encryptParameter} from '../../../service/ServiceParams';
import * as ExternalAPI from '../../../service/ExternalAPI';

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
    }

    async changeStatus(e){
        await this.setState({
            loading: true, 
        });
    }

    async getParams(){
        var obj = {}
        obj['page'] = this.state.page;
        obj['perpage'] = this.state.perpage;
        return obj;
    }

    async componentDidMount() {
        var $this = this;
        await this.setState({
            datatable: await $('#dataGroup').DataTable({
                "processing": true,
                "serverSide": true,
                "scrollX"   : true,
                "scrollY"   : true,
                "ajax" 		: this.state.url+"/api/v1/system_group/read",
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', "row-"+aData.id);
                },
                "columns": [
                    { 
                      "data": "group",
                    },{
                        "data"  : "active",
                        "render": function(data, type, row) {
                            var active = '<span class="right badge badge-primary">Active</span>';
                            if(row.active === false){
                                active = '<span class="right badge badge-danger">Not active</span>';
                            }
                            return active;
                        }
                    },
                    {
                        "data": "id",
                        "render": function (data, type, row) {
                            return '<div align="center">'+
                            '<div class="btn-group" role="group">'+
                            '<button class="btn btn-default btn-sm" data-name="update-group" data-id="'+row.id+'" data-group="'+row.group+'" data-active="'+row.active+'"><i class="fa fa-file"></i></button>'+
                            '<button class="btn btn-default btn-sm" data-name="delete-group" data-id="'+row.id+'"><i class="fa fa-trash"></i></button>'+
                            '</div>'+
                            '</div>';
                        }
                    }
                ],
            }),
        });
        
        $('#dataGroup tbody').on( 'click', 'button', async function () {
            // var data = table.row( $(this).parents('tr') ).data();
            if(typeof($(this).data().group) !== "undefined"){
                await $('#exampleModal').modal('show');
                await $('#id').val($(this).data().id);
                await $('#group').val($(this).data().group);
                await $("#active").prop('checked', $(this).data().active);
            }else{
                await Swal.fire({
                      title: 'Yakin untuk menghapus?',
                      showCancelButton: true,
                      confirmButtonText: `Hapus`,
                      cancelButtonText: `Batal`,
                    }).then(async (result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let result = await ExternalAPI.post(
                            $this.state.url+'/api/v1/system_group/delete', 
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
                })
            }
        } );
    }

    render() {
        return (
            <>
                <table id="dataGroup" width="100%" className="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Group</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </>
        );
    }
}

if (document.getElementById('cpanel-system_group-datagrid')) {
    const app = document.getElementById('cpanel-system_group-datagrid');
    ReactDOM.render(<DataGrid {...app.dataset}/>, document.getElementById('cpanel-system_group-datagrid'));
}
