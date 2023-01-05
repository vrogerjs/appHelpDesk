<div class="col">

    <div class="card card-primary">
        <div class="card-header">
            <div class="row">
                <h5 class="my-2 fw-bold col">Gestión de Responsables</h5>
                <div class="col text-end fw-bold">
                    <a class="btn btn-secondary btn-sm" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i>
                        Volver
                    </a>
                </div>
            </div>

        </div>
        <div class="card-body">
            <button href="#" class="btn btn-success" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Responsable</button>
        </div>
    </div>

    <div class="card card-success" v-if="divNuevo">
        <div class="card-header">
            <h5 class="m-0">Nuevo Responsable</h5>
        </div>

        <form v-on:submit.prevent="create">
            <div class="card-body">

                <div class="row">
                    <div class="col-12 input-group">
                        <label for="txtapellido" class="col-3 control-label">Apellidos: <b style="color: red"> *</b></label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="txtapellido" name="txtapellido" placeholder="Ingrese sus apellidos." maxlength="512" autofocus v-model="newApellido" >
                        </div>
                    </div>

                    <div class="col-12 input-group  mt-3">
                        <label for="txtnombre" class="col-3 control-label">Nombres: <b style="color: red"> *</b></label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="Ingrese sus nombres." maxlength="512" autofocus v-model="newNombre" >
                        </div>
                    </div>

                    <div class="col-12 input-group  mt-3">
                        <label for="txtcargo" class="col-3 control-label">Cargo: <b style="color: red"> *</b></label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="txtcargo" name="txtcargo" placeholder="Ingrese su cargo." maxlength="512" autofocus v-model="newCargo" >
                        </div>
                    </div>

                    <div class="col-12 input-group mt-3">
                        <label for="cbuestado" class="col-3 control-label">Estado:<b style="color: red"> *</b></label>
                        <div class="col-4">
                            <select class="form-control" id="cbuestado" name="cbuestado" v-model="newEstado">
                                <option value="1">Activado</option>
                                <option value="0">Desactivado</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info m-2" id="btnGuardar">Guardar</button>
                <button type="reset" class="btn btn-warning m-2" id="btnCancel" @click="cancelFormNuevo()">Cancelar</button>
                <button type="button" class="btn btn-secondary m-2" id="btnClose" @click.prevent="cerrarFormNuevo()">Cerrar</button>

                <div class="sk-circle" v-show="divloaderNuevo">
                    <div class="sk-circle1 sk-child"></div>
                    <div class="sk-circle2 sk-child"></div>
                    <div class="sk-circle3 sk-child"></div>
                    <div class="sk-circle4 sk-child"></div>
                    <div class="sk-circle5 sk-child"></div>
                    <div class="sk-circle6 sk-child"></div>
                    <div class="sk-circle7 sk-child"></div>
                    <div class="sk-circle8 sk-child"></div>
                    <div class="sk-circle9 sk-child"></div>
                    <div class="sk-circle10 sk-child"></div>
                    <div class="sk-circle11 sk-child"></div>
                    <div class="sk-circle12 sk-child"></div>
                </div>

            </div>
            <!-- /.card-footer -->

        </form>
    </div>

    <div class="card card-primary">
        <div class="card-header">

            <div class="row">
                <h5 class="my-2 fw-bold col">Listado de Responsables</h5>
                <div class="col text-end fw-bold input-group">
                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">
                    <button type="submit" class="btn btn-secondary" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
                </a>
            </div>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <table class="table table-hover table-bordered table-condensed table-striped" >
            <tbody>
                <tr class="table-light">
                    <th style="border:1px solid #ddd;width: 5%;">#</th>
                    <th style="border:1px solid #ddd;width: 20%;">Responsable</th>
                    <th style="border:1px solid #ddd;width: 25%;">Cargo</th>
                    <th style="border:1px solid #ddd;width: 10%;">Estado</th>
                    <th style="border:1px solid #ddd;width: 20%;">Gestión</th>
                </tr>
                <tr v-for="responsable, key in responsables">
                    <td style="border:1px solid #ddd;">@{{key+pagination.from}}</td>
                    <td style="border:1px solid #ddd;">@{{ responsable.nombres }} @{{ responsable.apellidos }}</td>
                    <td style="border:1px solid #ddd;">@{{ responsable.cargo }}</td>
                    <td style="border:1px solid #ddd;" style="vertical-align: middle;">
                        <center>
                            <span class="badge text-bg-success" v-if="responsable.activo=='1'">Activo</span>
                            <span class="badge text-bg-warning" v-if="responsable.activo=='0'">Inactivo</span>
                        </center>
                    </td>
                    <td style="border:1px solid #ddd;">
                        <center>
                            <a href="#" v-if="responsable.activo=='1'" class="btn bg-navy m-1" v-on:click.prevent="baja(responsable)" data-placement="top" data-toggle="tooltip" title="Desactivar Responsable."><i class="fa fa-arrow-circle-down"></i></a>
                            <a href="#" v-if="responsable.activo=='0'" class="btn btn-success m-1" v-on:click.prevent="alta(responsable)" data-placement="top" data-toggle="tooltip" title="Activar Responsable."><i class="fa fa-check-circle"></i></a>
                            <a href="#" class="btn btn-warning m-1" v-on:click.prevent="edit(responsable)" data-placement="top" data-toggle="tooltip" title="Editar Responsable."><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger m-1" v-on:click.prevent="borrar(responsable)" data-placement="top" data-toggle="tooltip" title="Borrar Responsable."><i class="fa fa-trash"></i></a>
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- /.card-body -->
    <div style="padding: 15px;">
        <div>
            <p class="m-0">Registros por Página: @{{ pagination.per_page }}</p>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination m-0">
                <li class="page-item" v-if="pagination.current_page>1">
                    <a class="page-link" href="#" @click.prevent="changePage(1)">
                        <span><b>Inicio</b></span>
                    </a>
                </li>

                <li class="page-item" v-if="pagination.current_page>1">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1)">
                        <span>Atras</span>
                    </a>
                </li>
                <li class="page-item" v-for="page in pagesNumber" v-bind:class="[page=== isActived ? 'active' : '']">
                    <a class="page-link" href="#" @click.prevent="changePage(page)">
                        <span>@{{ page }}</span>
                    </a>
                </li>
                <li class="page-item" v-if="pagination.current_page< pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1)">
                        <span>Siguiente</span>
                    </a>
                </li>
                <li class="page-item" v-if="pagination.current_page< pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.last_page)">
                        <span><b>Ultima</b></span>
                    </a>
                </li>
            </ul>
        </nav>
        <div>
            <p class="m-0">Registros Totales: @{{ pagination.total }}</p>
        </div>
    </div>
</div>

<form method="post" v-on:submit.prevent="updateResponsable(fillResponsable.id)">

    <div class="modal fade" id="modalEditar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-success bg-gradient">
                    <h1 class="modal-title fs-5 fw-bold" id="exampleModalToggleLabel">Actualizar Responsable</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-12 input-group">
                            <label for="txtapellidoE" class="col-3 control-label">Apellidos: <b style="color: red"> *</b></label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="txtapellidoE" name="txtapellidoE" placeholder="Ingrese sus apellidos." maxlength="512" autofocus v-model="fillResponsable.apellidos" >
                            </div>
                        </div>
    
                        <div class="col-12 input-group  mt-3">
                            <label for="txtnombre" class="col-3 control-label">Nombres: <b style="color: red"> *</b></label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="Ingrese sus nombres." maxlength="512" autofocus v-model="fillResponsable.nombres" >
                            </div>
                        </div>
    
                        <div class="col-12 input-group  mt-3">
                            <label for="txtcargo" class="col-3 control-label">Cargo: <b style="color: red"> *</b></label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="txtcargo" name="txtcargo" placeholder="Ingrese su cargo." maxlength="512" autofocus v-model="fillResponsable.cargo" >
                            </div>
                        </div>

                        <div class="col-12 input-group mt-3">
                            <label for="cbuestado" class="col-3 control-label">Estado:<b style="color: red"> *</b></label>
                            <div class="col-4">
                                <select class="form-control" id="cbuestado" name="cbuestado" v-model="fillResponsable.activo">
                                    <option value="1">Activado</option>
                                    <option value="0">Desactivado</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa-regular fa-floppy-disk"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCloseE" @click.prevent="cerrarFormE()"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

                    <div class="sk-circle" v-show="divloaderEdit">
                        <div class="sk-circle1 sk-child"></div>
                        <div class="sk-circle2 sk-child"></div>
                        <div class="sk-circle3 sk-child"></div>
                        <div class="sk-circle4 sk-child"></div>
                        <div class="sk-circle5 sk-child"></div>
                        <div class="sk-circle6 sk-child"></div>
                        <div class="sk-circle7 sk-child"></div>
                        <div class="sk-circle8 sk-child"></div>
                        <div class="sk-circle9 sk-child"></div>
                        <div class="sk-circle10 sk-child"></div>
                        <div class="sk-circle11 sk-child"></div>
                        <div class="sk-circle12 sk-child"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</div>
