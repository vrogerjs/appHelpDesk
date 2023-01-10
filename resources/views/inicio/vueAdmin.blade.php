<script>
    const {
        createApp
    } = Vue

    createApp({
        data() {
            return {
                divtitulo: true,
                subtitle2: false,
                titulo: "Página Principal",
                subtitulo: "Inicio",
                subtitulo2: "Principal",

                userPerfil: '{{ Auth::user()->name }}',
                mailPerfil: '{{ Auth::user()->email }}',

                divloader0: true,
                divloader1: false,
                divloader2: false,
                divloader3: false,
                divloader4: false,
                divloader5: false,
                divloader6: false,
                divloader7: false,
                divloader8: false,
                divloader9: false,
                divloader10: false,

                classMenu: 'nav-link active',
                classMenu1: 'nav-link ',
                classMenu2: 'nav-link ',
                classMenu3: 'nav-link ',
                classMenu4: 'nav-link ',
                classMenu5: 'nav-link ',
                classMenu6: 'nav-link ',
                classMenu7: 'nav-link ',
                classMenu8: 'nav-link ',
                classMenu9: 'nav-link ',
                classMenu10: 'nav-link ',
                classMenu11: 'nav-link ',
                classMenu12: 'nav-link ',

                divhome: false,

                uploadReadyG: true,
                archivoGa: null,

                divloaderEdit: false,


            }
        },
        mounted() {
            this.divloader0 = false;
            this.divhome = true;
            $("#divtitulo").show('slow');

            // $("#modalAlerta").modal('show');
        },
        methods: {

            onClick: function() {
                // $("#modalAlerta").modal('show');
            }

        }
    }).mount('#app')
</script>
