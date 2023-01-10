<script>
    const {
        createApp
    } = Vue

    createApp({
        data() {
            return {
                divtitulo: true,
                subtitle2: false,
                nombre: "Configuraciones Principales",
                subtitulo: "Inicio",
                subtitulo2: "Categoría",

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

                categorias: [],
                responsables: [],
                cburesponsables: [],
                users: [],
                errors: [],

                fillCategoria: {
                    'id': '',
                    'name': '',
                    'descripcion': '',
                    'activo': ''
                },

                fillCategoriaResponsable: {
                    'categoria_id': ''
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

                newName: '',
                newDescripcion: '',
                newResponsable: '',
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
                var url = 'categoria?page=' + page + '&busca=' + busca;

                axios.get(url).then(response => {
                    this.categorias = response.data.categorias.data;
                    this.pagination = response.data.pagination;

                    if (this.categorias.length == 0 && this.thispage != '1') {
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
                this.newName = '';
                this.newDescripcion = '';
                this.newResponsable = '';
                this.newEstado = '1';
            },

            create: function() {
                var url = 'categoria';
                $("#btnGuardar").attr('disabled', true);
                $("#btnCancel").attr('disabled', true);
                $("#btnClose").attr('disabled', true);
                this.divloaderNuevo = true;

                var data = new FormData();

                data.append('name', this.newName);
                data.append('descripcion', this.newDescripcion);
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

            borrar: function(categoria) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Desea eliminar la Categoría Seleccionada? -- Nota: este proceso no se podrá revertir.",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'categoria/' + categoria.id;
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

            edit: function(categoria) {
                this.fillCategoria.id = categoria.id;
                this.fillCategoria.name = categoria.name;
                this.fillCategoria.descripcion = categoria.descripcion;
                this.fillCategoria.activo = categoria.activo;

                $("#modalEditar").modal('show');

                this.$nextTick(() => {
                    $("#txtnameE").focus();
                });
            },

            cerrarFormE: function() {
                $("#modalEditar").modal('hide');
                this.$nextTick(function() {
                    this.fillCategoria = {
                        'id': '',
                        'nombre': '',
                        'descripcion': '',
                        'activo': ''
                    };
                })
            },

            updateCategoria: function(id) {
                var url = "/categoria/" + id;
                $("#btnSaveE").attr('disabled', true);
                $("#btnCloseE").attr('disabled', true);
                this.divloaderEdit = true;

                var data = new FormData();
                data.append('id', this.fillCategoria.id);
                data.append('name', this.fillCategoria.name);
                data.append('descripcion', this.fillCategoria.descripcion);
                data.append('activo', this.fillCategoria.activo);
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

            verResponsable: function(categoria) {

                this.fillCategoriaResponsable.categoria_id = categoria.id;

                $("#modalAsignar").modal('show');
                // this.fillResponsable.id=responsable.id;
                var url = '/verResponsables/' + categoria.id;
                axios.get(url).then(response => {
                    console.log('Demo:', response);
                    this.responsables = response.data.responsables.data;
                    this.cburesponsables = response.data.cburesponsables;
                })
                this.$nextTick(() => {
                    $("#txtapellidoE").focus();
                });
            },

            cerrarFormResponsable: function() {
                $("#modalAsignar").modal('hide');
                this.newResponsable = '';
                this.$nextTick(function() {
                    this.fillCategoriaResponsable = {
                        'categoria_id': ''
                    };
                })
            },

            asignarResponsable: function(categoria_id) {
                var url = "/asignarresponsable/" + categoria_id;
                $("#btnSaveE").attr('disabled', true);
                $("#btnCloseE").attr('disabled', true);
                this.divloaderEdit = true;

                var data = new FormData();
                data.append('categoria_id', this.fillCategoriaResponsable.categoria_id);
                data.append('responsable_id', this.newResponsable);
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
                        this.cerrarFormResponsable();
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

            baja: function(categoria) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Desea desactivar la Categoría.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Desactivar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'categoria/altabaja/' + categoria.id + '/0';
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

            alta: function(categoria) {
                swal.fire({
                    title: '¿Estás seguro?',
                    text: "Desea activar la Categoría.",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Activar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'categoria/altabaja/' + categoria.id + '/1';
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
