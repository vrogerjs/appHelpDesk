<script>
    const {
        createApp
    } = Vue

    const BASE_URL = '{{ url('') }}';

    createApp({
        data() {
            return {
                divtitulo: true,
                subtitle2: false,
                nombre: "Configuraciones Principales",
                subtitulo: "Inicio",
                subtitulo2: "Incidencia",

                userPerfil: '{{ Auth::user()->name }}',
                mailPerfil: '{{ Auth::user()->email }}',

                classMenu: 'nav-link',
                classMenu1: 'nav-link',
                classMenu2: 'nav-link active',
                classMenu3: 'nav-link',
                classMenu4: 'nav-link',
                classMenu5: 'nav-link',
                classMenu6: 'nav-link',
                classMenu7: 'nav-link',
                classMenu8: 'nav-link',
                classMenu9: 'nav-link',
                classMenu10: 'nav-link',
                classMenu11: 'nav-link',
                classMenu12: 'nav-link',

                divprincipal: false,

                incidencias: [],
                categorias: [],
                errors: [],
                oficinasAPI: [],

                fillIncidencias: {
                    'id': '',
                    'detalle': ''
                },

                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                },
                offset: 9,
                buscar: '',
                divNuevo: false,
                divloaderNuevo: false,
                divloaderEdit: false,

                thispage: '1',

                newMotivo: '',
                newDetalle: '',
                newOficina: '',
                newCategoria: '',
                newPrioridad: '1',
                newEstado: '1',
                nombreOficina: '',
            }
        },

        created() {
            this.getDatos(this.thispage);
        },

        mounted() {
            this.divloader0 = false;
            this.divprincipal = true;
            $("#divtitulo").show('slow');
        },

        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset
                var from2 = this.pagination.current_page - this.offset
                if (from < 1) {
                    from = 1;
                }

                var to = from2 + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },

        methods: {

            getDatos: function(page) {
                var busca = this.buscar;
                var url = 'incidencia?page=' + page + '&busca=' + busca;

                axios.get(url).then(response => {
                    this.incidencias = response.data.incidencias.data;
                    this.pagination = response.data.pagination;
                    this.categorias = response.data.categorias;
                    this.oficinas = response.data.oficinas;
                    this.oficinasAPI = response.data.oficinasAPI;

                    if (this.oficinasAPI.data[0].dependency.fullName->isEmpty()) {
                        this.nombreOficina = this.oficinasAPI.data[0].dependency.fullName;
                    } else {
                        this.nombreOficina = 'Oficina default';
                    }

                    console.log('holaaaa', this.abc);

                    if (this.incidencias.length == 0 && this.thispage != '1') {
                        var a = parseInt(this.thispage);
                        a--;
                        this.thispage = a.toString();
                        this.changePage(this.thispage);
                    }
                })
            },

            changePage: function(page) {
                this.pagination.current_page = page;
                this.getDatos(page);
                this.thispage = page;
            },

            buscarBtn: function() {
                this.getDatos();
                this.thispage = '1';
            },

            nuevo: function() {
                this.divNuevo = true;
                this.$nextTick(function() {
                    this.cancelFormNuevo();
                })
            },

            cerrarFormNuevo: function() {
                this.divNuevo = false;
                this.cancelFormNuevo();
            },

            cancelFormNuevo: function() {
                $('#txtname').focus();
                this.newMotivo = '';
                this.newDetalle = '';
                this.newOficina = '';
                this.newCategoria = '';
                this.newPrioridad = '1';
                this.newEstado = '1';
            },

            create: function() {
                var url = 'incidencia';
                $("#btnGuardar").attr('disabled', true);
                $("#btnCancel").attr('disabled', true);
                $("#btnClose").attr('disabled', true);
                this.divloaderNuevo = true;
                this.newCategoria = $("#cbucategoria").val();

                var data = new FormData();

                data.append('motivo', this.newMotivo);
                data.append('detalle', this.newDetalle);
                data.append('categoria_id', this.newCategoria);
                data.append('prioridad', this.newPrioridad);
                data.append('oficina', this.nombreOficina);
                data.append('activo', this.newEstado);

                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };

                axios.post(url, data, config).then(response => {

                    $("#btnGuardar").removeAttr("disabled");
                    $("#btnCancel").removeAttr("disabled");
                    $("#btnClose").removeAttr("disabled");
                    this.divloaderNuevo = false;

                    if (String(response.data.result) == '1') {
                        this.getDatos(this.thispage);
                        this.errors = [];
                        this.cerrarFormNuevo();
                        toastr.success(response.data.msj);
                    } else {
                        $('#' + response.data.selector).focus();
                        $('#' + response.data.selector).css("border", "1px solid red");
                        toastr.error(response.data.msj);
                    }
                }).catch(error => {
                    //this.errors=error.response.data
                })
            },

            borrar: function(incidencia) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Desea eliminar la Incidencia Seleccionada? -- Nota: este proceso no se podrá revertir.",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'incidencia/' + incidencia.id;
                        axios.delete(url).then(response => { //eliminamos
                            if (response.data.result == '1') {
                                this.getDatos(this.thispage); //listamos
                                toastr.success(response.data.msj); //mostramos mensaje
                            } else {
                                // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                        })
                    }
                }).catch(swal.noop);
            },

            editIncidencia: function(incidencia) {
                this.fillIncidencias.id = incidencia.id;
                this.fillIncidencias.detalle = '';

                $("#modalEditar").modal('show');

                this.$nextTick(() => {
                    $("#txtdetalleE").focus();
                });
            },

            cerrarFormE: function() {
                $("#modalEditar").modal('hide');
                this.$nextTick(function() {
                    this.fillIncidencias = {
                        'id': '',
                        'detalle': ''
                    };
                })
            },

            updateIncidencia: function(id) {

                // var url = "/incidencia/" + id;
                var url = `${BASE_URL}/incidencia/${id}`;

                $("#btnSaveE").attr('disabled', true);
                $("#btnCloseE").attr('disabled', true);
                this.divloaderEdit = true;

                var data = new FormData();
                data.append('id', this.fillIncidencias.id);
                data.append('detalle', this.fillIncidencias.detalle);

                data.append('_method', 'PUT');

                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };

                axios.post(url, data, config).then(response => {

                    $("#btnSaveE").removeAttr("disabled");
                    $("#btnCloseE").removeAttr("disabled");
                    this.divloaderEdit = false;

                    if (response.data.result == '1') {
                        this.cerrarFormE();
                        this.getDatos(this.thispage);
                        toastr.success(response.data.msj);
                    } else {
                        $('#' + response.data.selector).focus();
                        toastr.error(response.data.msj);
                    }
                }).catch(error => {
                    this.errors = error.response.data
                })
            },

            baja: function(incidencia) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Desea desactivar la Incidencia.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Desactivar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'incidencia/altabaja/' + incidencia.id + '/0';
                        axios.get(url).then(response => { //eliminamos
                            if (response.data.result == '1') {
                                this.getDatos(this.thispage); //listamos
                                toastr.success(response.data.msj); //mostramos mensaje
                            } else {
                                // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                        });
                    }
                }).catch(swal.noop);
            },

            alta: function(incidencia) {
                swal.fire({
                    title: '¿Estás seguro?',
                    text: "Desea activar la Incidencia.",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Activar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'incidencia/altabaja/' + incidencia.id + '/1';
                        axios.get(url).then(response => { //eliminamos
                            if (response.data.result == '1') {
                                this.getDatos(this.thispage); //listamos
                                toastr.success(response.data.msj); //mostramos mensaje
                            } else {
                                // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                        });
                    }
                }).catch(swal.noop);
            }
        }
    }).mount('#app')
</script>
