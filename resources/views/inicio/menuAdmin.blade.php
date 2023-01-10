<div class="col">  
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">Bienvenidos al Menú Principal</h3>
    </div>
    <div class="card-body">
      <div class="row">
        
        @if (accesoUser([1]))
        <div class="col-lg-3 col-6">          
          <div class="small-box bg-info" style="height: 143px;">
            <div class="inner">
              {{-- <h3>10</h3> --}}
              <p>Gestión de Categorías</p>
            </div>
            <div class="icon pt-4">
              <i class="fas fa-bag"></i>
            </div>
            <a href="/categorias" class="small-box-footer">Ingresar <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif

        @if (accesoUser([1]))
        <div class="col-lg-3 col-6">          
          <div class="small-box bg-success" style="height: 143px;">
            <div class="inner">
              {{-- <h3>53<sup style="font-size: 20px">%</sup></h3> --}}
              <p>Gestión de Responsables</p>
            </div>
            <div class="icon pt-4">
              <i class="fas fa-stats-bars"></i>
            </div>
            <a href="/responsables" class="small-box-footer">Ingresar <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif

        @if (accesoUser([1,2,3]))
        <div class="col-lg-3 col-6">          
          <div class="small-box bg-warning" style="height: 143px;">
            <div class="inner">
              {{-- <h3>44</h3> --}}
              <p>Gestión de Tikets</p>
            </div>
            <div class="icon pt-4">
              <i class="fas fa-person-add"></i>
            </div>
            <a href="incidencias" class="small-box-footer">Ingresar <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif
        
        @if (accesoUser([1,2,3]))
        <div class="col-lg-3 col-6">          
          <div class="small-box bg-danger" style="height: 143px;">
            <div class="inner">
              {{-- <h3>65</h3> --}}
              <p>Gestión de Respuestas</p>
            </div>
            <div class="icon pt-4">
              <i class="fas fa-pie-graph"></i>
            </div>
            <a href="solucions" class="small-box-footer">Ingresar <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif
        
      </div>
    </div>
  </div>
</div>


