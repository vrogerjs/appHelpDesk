
<script>
const { createApp } = Vue

createApp({
	data() {
		return {
			divtitulo:true,
			subtitle2:false,
			titulo:"Página Principal",
			subtitulo: "Inicio",
			subtitulo2: "Principal",
			
			userPerfil:'{{ Auth::user()->name }}',
			mailPerfil:'{{ Auth::user()->email }}',
			
			divloader0:true,
			divloader1:false,
			divloader2:false,
			divloader3:false,
			divloader4:false,
			divloader5:false,
			divloader6:false,
			divloader7:false,
			divloader8:false,
			divloader9:false,
			divloader10:false,
			
			
			classTitle:'fa fa-home',
			classMenu0:'active',
			classMenu1:'',
			classMenu2:'',
			classMenu3:'',
			classMenu4:'',
			classMenu5:'',
			classMenu6:'',
			classMenu7:'',
			classMenu8:'',
			classMenu9:'',
			classMenu10:'',
			classMenu11:'',
			classMenu12:'',
			
			divhome:false,
			
			uploadReadyG:true,
			archivoGa:null,
			
			divloaderEdit:false,
			
			
		}
	},
	mounted() {
		this.divloader0=false;
		this.divhome=true;
		$("#divtitulo").show('slow');
		
		// $("#modalAlerta").modal('show');
	},
	methods: {
		
		onClick:function(){
			$("#modalAlerta").modal('show');
		}
		
	}
}).mount('#app')
</script>