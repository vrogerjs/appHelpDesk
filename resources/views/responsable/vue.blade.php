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
                subtitulo2: "Responsable",

                userPerfil: '{{ Auth::user()->name }}',
                mailPerfil: '{{ Auth::user()->email }}',

                classMenu: 'nav-link',
                classMenu1: 'nav-link active',
                classMenu2: 'nav-link',
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

                responsables: [],
                errors: [],

                fillResponsable: {
                    'id': '',
                    'nombres': '',
                    'cargo': '',
                    'activo': ''
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

                newApellido: '',
                newNombre: '',
                newCargo: '',
                newEstado: '1',
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
                var url = 'responsable?page=' + page + '&busca=' + busca;

                axios.get(url).then(response => {
                    this.responsables = response.data.responsables.data;
                    this.pagination = response.data.pagination;

                    if (this.responsables.length == 0 && this.thispage != '1') {
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
                $('#txtapellido').focus();
                this.newApellido = '';
                this.newNombre = '';
                this.newCargo = '';
                this.newEstado = '1';
            },

            create: function() {
                var url = 'responsable';
                $("#btnGuardar").attr('disabled', true);
                $("#btnCancel").attr('disabled', true);
                $("#btnClose").attr('disabled', true);
                this.divloaderNuevo = true;

                var data = new FormData();

                data.append('nombres', this.newNombre);
                data.append('cargo', this.newCargo);
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

            borrar: function(responsable) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Desea eliminar el Responsable Seleccionada? -- Nota: este proceso no se podrá revertir.",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'responsable/' + responsable.id;
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

            edit: function(responsable) {
                this.fillResponsable.id = responsable.id;
                this.fillResponsable.nombres = responsable.nombres;
                this.fillResponsable.cargo = responsable.cargo;
                this.fillResponsable.activo = responsable.activo;

                $("#modalEditar").modal('show');

                this.$nextTick(() => {
                    $("#txtapellidoE").focus();
                });
            },

            cerrarFormE: function() {
                $("#modalEditar").modal('hide');
                this.$nextTick(function() {
                    this.fillResponsable = {
                        'id': '',
                        'nombres': '',
                        'cargo': '',
                        'activo': ''
                    };
                })
            },

            updateResponsable: function(id) {
                // var url = "/responsable/" + id;
                var url = `${BASE_URL}/responsable/${id}`;
                $("#btnSaveE").attr('disabled', true);
                $("#btnCloseE").attr('disabled', true);
                this.divloaderEdit = true;

                var data = new FormData();
                data.append('id', this.fillResponsable.id);
                data.append('nombres', this.fillResponsable.nombres);
                data.append('cargo', this.fillResponsable.cargo);
                data.append('activo', this.fillResponsable.activo);
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

            baja: function(responsable) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Desea desactivar el Responsable.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Desactivar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'responsable/altabaja/' + responsable.id + '/0';
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

            alta: function(responsable) {
                swal.fire({
                    title: '¿Estás seguro?',
                    text: "Desea activar el Responsable.",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Activar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'responsable/altabaja/' + responsable.id + '/1';
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
