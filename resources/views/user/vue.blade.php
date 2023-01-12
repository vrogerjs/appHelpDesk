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
                subtitulo2: "Usuario",

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

                users: [],
                tipousers: [],
                errors: [],

                fillUsers: {
                    'id': '',
                    'nombres': '',
                    'name': '',
                    'email': '',
                    'password': '',
                    'tipouser_id': '',
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

                newNombre: '',
                newName: '',
                newEmail: '',
                newPassword: '',
                newTipouser: '',
                newEstado: '1'
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
                var url = 'user?page=' + page + '&busca=' + busca;

                axios.get(url).then(response => {
                    this.users = response.data.users.data;
                    this.pagination = response.data.pagination;
                    this.tipousers = response.data.tipousers;

                    if (this.users.length == 0 && this.thispage != '1') {
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
                $('#txtnombre').focus();
                this.newNombre = '';
                this.newName = '';
                this.newEmail = '';
                this.newPassword = '';
                this.newTipouser = '';
                this.newEstado = '1';
            },

            create: function() {
                var url = 'user';
                $("#btnGuardar").attr('disabled', true);
                $("#btnCancel").attr('disabled', true);
                $("#btnClose").attr('disabled', true);
                this.divloaderNuevo = true;
                this.newTipouser = $("#cbutipouser").val();

                var data = new FormData();

                data.append('nombres', this.newNombre);
                data.append('name', this.newName);
                data.append('email', this.newEmail);
                data.append('password', this.newPassword);
                data.append('tipouser_id', this.newTipouser);
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

            borrar: function(user) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Desea eliminar el Usuario Seleccionada? -- Nota: este proceso no se podrá revertir.",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'user/' + user.id;
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

            edit: function(user) {
                this.fillUsers.id = user.id;
                this.fillUsers.nombres = user.nombres;
                this.fillUsers.name = user.name;
                this.fillUsers.email = user.email;
                this.fillUsers.password = user.password;
                this.fillUsers.tipouser_id = user.tipouser_id;
                this.fillUsers.activo = user.activo;

                $("#modalEditar").modal('show');

                this.$nextTick(() => {
                    $("#txtnombreE").focus();
                });
            },

            cerrarFormE: function() {
                $("#modalEditar").modal('hide');
                this.$nextTick(function() {
                    this.fillUsers = {
                        'id': '',
                        'nombres': '',
                        'name': '',
                        'email': '',
                        'password': '',
                        'tipouser_id': '',
                        'activo': ''
                    };
                })
            },

            updateUser: function(id) {

                // var url = "/user/" + id;
                var url = `${BASE_URL}/user/${id}`;

                $("#btnSaveE").attr('disabled', true);
                $("#btnCloseE").attr('disabled', true);
                this.divloaderEdit = true;
                this.fillUsers.tipouser_id = $("#cbutipouser").val();

                var data = new FormData();
                data.append('id', this.fillUsers.id);
                data.append('nombres', this.fillUsers.nombres);
                data.append('name', this.fillUsers.name);
                data.append('email', this.fillUsers.email);
                data.append('password', this.fillUsers.password);
                data.append('tipouser_id', this.fillUsers.tipouser_id);
                data.append('activo', this.fillUsers.activo);

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

            baja: function(user) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Desea desactivar el Usuario.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Desactivar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'user/altabaja/' + user.id + '/0';
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

            alta: function(user) {
                swal.fire({
                    title: '¿Estás seguro?',
                    text: "Desea activar el Usuario.",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Activar'
                }).then((result) => {
                    if (result.value) {
                        var url = 'user/altabaja/' + user.id + '/1';
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
