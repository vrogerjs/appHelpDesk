<div class="col">
    <div class="card card-primary">
        <div class="card-header">

            <div class="row">
                <h5 class="my-2 fw-bold col">Listado de Incidencias Resueltas</h5>
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
                    <th style="border:1px solid #ddd;width: 3%;">#</th>
                    <th style="border:1px solid #ddd;width: 10%;">Categoría</th>
                    <th style="border:1px solid #ddd;width: 25%;">Incidencia</th>
                    <th style="border:1px solid #ddd;width: 10%;">Fecha de Incidencia</th>
                    <th style="border:1px solid #ddd;width: 15%;">Oficina</th>
                    <th style="border:1px solid #ddd;width: 5%;">Prioridad</th>
                    <th style="border:1px solid #ddd;width: 10%;">Estado</th>
                    <th style="border:1px solid #ddd;width: 20%;">Solución</th>
                </tr>
                <tr v-for="solucion, key in solucions">
                    <td style="border:1px solid #ddd;">@{{key+pagination.from}}</td>
                    <td style="border:1px solid #ddd;">@{{ solucion.categoria }}</td>
                    <td style="border:1px solid #ddd;"><b>Título: </b>@{{ solucion.motivo }} <br><b>Detalle: </b>@{{ solucion.detalle }}</td>
                    <td style="border:1px solid #ddd;">@{{ solucion.fecincidencia }}</td>
                    <td style="border:1px solid #ddd;">@{{ solucion.oficina }} <br><p style="font-size: 13px;color: gray;">@{{ solucion.nombres }}</p></td>
                    <td style="border:1px solid #ddd;" style="vertical-align: middle;">
                        <center>
                            <span class="badge text-bg-success" v-if="solucion.prioridad=='0'">Baja</span>
                            <span class="badge text-bg-warning" v-if="solucion.prioridad=='1'">Media</span>
                            <span class="badge text-bg-danger" v-if="solucion.prioridad=='2'">Alta</span>
                        </center>
                    </td>
                    <td style="border:1px solid #ddd;" style="vertical-align: middle;">
                        <center>
                            <span class="badge text-bg-danger" v-if="solucion.estado=='0'">Pendiente</span>
                            <span class="badge text-bg-success" v-if="solucion.estado=='1'">Atendido</span>
                        </center>
                    </td>
                    <td style="border:1px solid #ddd;">@{{ solucion.soldetalle }}<br><p style="font-size: 12px;color: gray;"><b>Fecha y Hora: </b>@{{ solucion.fecsolucion }} <br>@{{ solucion.usernombre }}</p></td>
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

</div>
