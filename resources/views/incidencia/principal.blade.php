<div class="col">

    <div class="card card-primary">
        <div class="card-header">
            <div class="row">
                <h5 class="my-2 fw-bold col">Gestión de Incidencias</h5>
                <div class="col text-end fw-bold">
                    <a class="btn btn-secondary btn-sm" type="button" class="btn btn-default"
                        href="{{ URL::to('home') }}"><i class="fa fa-reply-all" aria-hidden="true"></i>
                        Volver
                    </a>
                </div>
            </div>

        </div>
        <div class="card-body">
            <button href="#" class="btn btn-success" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus"
                    aria-hidden="true"></i> Nueva Incidencia</button>
        </div>
    </div>

    <div class="card card-success" v-if="divNuevo">
        <div class="card-header">
            <h5 class="m-0">Nuevo Ticket de Incidencia</h5>
        </div>

        <form v-on:submit.prevent="create">
            <div class="card-body">

                <div class="row">

                    <div class="col-12 input-group">
                        <label for="cbucategoria" class="col-3 control-label">Seleccione la Categoría : <b
                                style="color: red"> *</b></label>
                        <div class="col-9">
                            <select name="cbucategoria" id="cbucategoria" class="form-control" v-model="newCategoria">
                                <option disabled value="">Seleccione la Categoría</option>
                                <option v-for="categoria, key in categorias" v-bind:value="categoria.id">
                                    @{{ categoria.name }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 input-group mt-3">
                        <label for="" class="col-3 control-label">Seleccione la Oficina : <b style="color: red">
                                *</b></label>
                        <div class="col-9">
                            <p class="form-control" v-if="nombreOficina != ''">@{{ nombreOficina }}</p>

                            <input type="text" class="form-control" id="txtoficina" name="txtoficina"
                                placeholder="Ingrese el nombre de la Oficina." maxlength="512" v-model="newOficina"
                                v-if="nombreOficina == ''">
                        </div>

                    </div>

                    <div class="col-12 input-group mt-3">
                        <label for="txtmotivo" class="col-3 control-label">Título de la Incidencia: <b
                                style="color: red"> *</b></label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="txtmotivo" name="txtmotivo"
                                placeholder="Ingrese el título de la incidencia." maxlength="512" autofocus
                                v-model="newMotivo">
                        </div>
                    </div>

                    <div class="col-12 input-group mt-3">
                        <label for="txtdetalle" class="col-3 control-label">Detalle de la Incidencia: <b
                                style="color: red"> *</b></label>
                        <div class="col-8">
                            <textarea id="txtdetalle" name="txtdetalle" class="form-control" placeholder="Ingrese a detalle la incidencia."
                                maxlength="1024" v-model="newDetalle"></textarea>
                        </div>
                    </div>

                    {{-- <div class="col-12 input-group mt-3">
                        <label for="txtoficina" class="col-3 control-label">Oficina Administrativa: <b style="color: red"> *</b></label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="txtoficina" name="txtoficina" placeholder="Ingrese el nombre de la Oficina." maxlength="512" autofocus v-model="newOficina">
                        </div>
                    </div> --}}

                    <div class="col-12 input-group mt-3">
                        <label for="cbuprioridad" class="col-3 control-label">Prioridad:<b style="color: red">
                                *</b></label>
                        <div class="col-2">
                            <select class="form-control" id="cbuprioridad" name="cbuprioridad" v-model="newPrioridad">
                                <option value="0" class="bg-green">Baja</option>
                                <option value="1" class="bg-yellow">Media</option>
                                <option value="2" class="bg-red">Alta</option>
                            </select>
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
                <button type="reset" class="btn btn-warning m-2" id="btnCancel"
                    @click="cancelFormNuevo()">Cancelar</button>
                <button type="button" class="btn btn-secondary m-2" id="btnClose"
                    @click.prevent="cerrarFormNuevo()">Cerrar</button>

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
                <h5 class="my-2 fw-bold col">Listado de Incidencias</h5>
                <div class="col text-end fw-bold input-group">
                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar"
                        v-model="buscar" @keyup.enter="buscarBtn()">
                    <button type="submit" class="btn btn-secondary" @click.prevent="buscarBtn()"><i
                            class="fa fa-search"></i></button>
                    </a>
                </div>
            </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered table-condensed table-striped">
                <tbody>
                    <tr class="table-light">
                        <th style="border:1px solid #ddd;width: 3%;">#</th>
                        <th style="border:1px solid #ddd;width: 10%;">Categoría</th>
                        <th style="border:1px solid #ddd;width: 30%;">Incidencia</th>
                        <th style="border:1px solid #ddd;width: 20%;">Fecha de Incidencia</th>
                        <th style="border:1px solid #ddd;width: 20%;">Oficina</th>
                        <th style="border:1px solid #ddd;width: 5%;">Prioridad</th>
                        <th style="border:1px solid #ddd;width: 10%;">Estado</th>
                        @if (accesoUser([1, 2]))
                            <th style="border:1px solid #ddd;width: 20%;">Gestión</th>
                        @endif
                    </tr>
                    <tr v-for="incidencia, key in incidencias">
                        <td style="border:1px solid #ddd;">@{{ key + pagination.from }}</td>
                        <td style="border:1px solid #ddd;">@{{ incidencia.categoria }}</td>
                        <td style="border:1px solid #ddd;"><b>Título: </b>@{{ incidencia.motivo }} <br><b>Detalle:
                            </b>@{{ incidencia.detalle }}</td>
                        <td style="border:1px solid #ddd;">@{{ incidencia.fecincidencia }}</td>
                        <td style="border:1px solid #ddd;">@{{ incidencia.oficina }} <br>
                            <p style="font-size: 13px;color: gray;">@{{ incidencia.nombres }}</p>
                        </td>
                        <td style="border:1px solid #ddd;" style="vertical-align: middle;">
                            <center>
                                <span class="badge text-bg-success" v-if="incidencia.prioridad=='0'">Baja</span>
                                <span class="badge text-bg-warning" v-if="incidencia.prioridad=='1'">Media</span>
                                <span class="badge text-bg-danger" v-if="incidencia.prioridad=='2'">Alta</span>
                            </center>
                        </td>
                        <td style="border:1px solid #ddd;" style="vertical-align: middle;">
                            <center>
                                <span class="badge text-bg-warning" v-if="incidencia.estado=='0'">Pendiente</span>
                                <span class="badge text-bg-success" v-if="incidencia.estado=='1'">Atendido</span>
                            </center>
                        </td>

                        @if (accesoUser([1, 2]))
                            <td style="border:1px solid #ddd;">
                                <center>
                                    <a href="#" class="btn btn-success m-1"
                                        v-on:click.prevent="editIncidencia(incidencia)" data-placement="top"
                                        data-toggle="tooltip" title="Solucionar Incidencia."><i
                                            class="fa fa-circle-check"></i></a>
                                </center>
                            </td>
                        @endif
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
                    <li class="page-item" v-for="page in pagesNumber"
                        v-bind:class="[page=== isActived ? 'active' : '']">
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

    <form method="post" v-on:submit.prevent="updateIncidencia(fillIncidencias.id)">

        <div class="modal fade" id="modalEditar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header bg-success bg-gradient">
                        <h1 class="modal-title fs-5 fw-bold" id="exampleModalToggleLabel">Registrar Solución</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12 input-group mt-3">
                                <label for="txtdetalleE" class="col-3 control-label">Solución de la Incidencia: <b
                                        style="color: red"> *</b></label>
                                <div class="col-8">
                                    <textarea id="txtdetalleE" rows="5" name="txtdetalleE" class="form-control"
                                        placeholder="Ingrese la solución a detalle de la incidencia." v-model="fillIncidencias.detalle"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnSaveE"><i
                                class="fa-regular fa-floppy-disk"></i> Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btnCloseE"
                            @click.prevent="cerrarFormE()"><i class="fa fa-sign-out" aria-hidden="true"></i>
                            Cerrar</button>

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
