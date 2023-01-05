<script>
    const { createApp } = Vue

    createApp({
        data() {
            return {
                divtitulo:true,
                subtitle2:false,
                nombre:"Configuraciones Principales",
                subtitulo: "Inicio",
                subtitulo2: "Solucion",

                userPerfil:'{{ Auth::user()->name }}',
                mailPerfil:'{{ Auth::user()->email }}',

                classMenu:'nav-link',
                classMenu1:'nav-link',
                classMenu2:'nav-link active',
                classMenu3:'nav-link',
                classMenu4:'nav-link',
                classMenu5:'nav-link',
                classMenu6:'nav-link',
                classMenu7:'nav-link',
                classMenu8:'nav-link',
                classMenu9:'nav-link',
                classMenu10:'nav-link',
                classMenu11:'nav-link',
                classMenu12:'nav-link',

                divprincipal:false,

                solucions: [],
                errors:[],

                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                },
                offset: 9,
                buscar:'',
                divNuevo:false,
                divloaderNuevo:false,
                divloaderEdit:false,

                thispage:'1',
            }
        },

        created() {
            this.getDatos(this.thispage);
        },

        mounted() {
            this.divloader0=false;
            this.divprincipal=true;
            $("#divtitulo").show('slow');
        },

        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function () {
                if(!this.pagination.to){
                    return [];
                }

                var from=this.pagination.current_page - this.offset
                var from2=this.pagination.current_page - this.offset
                if(from<1){
                    from=1;
                }

                var to= from2 + (this.offset*2);
                if(to>=this.pagination.last_page){
                    to=this.pagination.last_page;
                }

                var pagesArray = [];
                while(from<=to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },

        methods: {

            getDatos: function (page) {
                var busca=this.buscar;
                var url = 'solucion?page='+page+'&busca='+busca;

                axios.get(url).then(response=>{
                    this.solucions= response.data.solucions.data;
                    this.pagination= response.data.pagination;

                    if(this.solucions.length==0 && this.thispage!='1'){
                        var a = parseInt(this.thispage) ;
                        a--;
                        this.thispage=a.toString();
                        this.changePage(this.thispage);
                    }
                })
            },

            changePage:function (page) {
                this.pagination.current_page=page;
                this.getDatos(page);
                this.thispage=page;
            },

            buscarBtn: function () {
                this.getDatos();
                this.thispage='1';
            }
        }
    }).mount('#app')

</script>
