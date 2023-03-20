 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/img/fabprueba.png" class="brand-image-xl">
        <span class="brand-text font-weight-light">TARIPAÑAJOB</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="info">
                <router-link class="nav-link" to='/datosUser'>
                <a id="nombre" class="d-block"></a>
              </router-link>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              
              <li class="nav-header" style="padding-left: 1px;">FOJA DE CONCEPTO</li>
              @can('vist-eval', Model::class)
                <li class="nav-item">{{-- DATOS PERSONALES --}}
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-id-card"></i>
                    <p>
                      EVALUACIONES
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="display: none;">
                    @can('create-evalu', Model::class)
                      <li class="nav-item">
                        <router-link class="nav-link" to='/listaEvaluaciones'>
                          <i class="fas fa-user nav-icon"></i>
                          <p>Evaluaciones</p>
                        </router-link>
                      </li>  
                    @endcan
                    
                    
                    
                  </ul>
                </li> 
              @endcan
              @can('vist-cali', Model::class)
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-paste"></i>
                        <p>
                            CALIFICACIONES
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('index-cali', Model::class)
                          <li class="nav-item">
                              <router-link class="nav-link" to='/indexEvaluacion'><i class="fas fa-chalkboard-teacher"></i> &nbsp;&nbsp;<p>Calificacion</p> </router-link>
                          </li>  
                        @endcan
                        
                    </ul>
                </li>
              @endcan
              @can('vist-impre', Model::class )
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-paste"></i>
                        <p>
                            FOJAS DE CONCEPTO
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('index-impre', Model::class)
                          <li class="nav-item">
                              <router-link class="nav-link" to='/reporte'><i class="fas fa-scroll"></i> &nbsp;&nbsp;<p>Impresion</p> </router-link>
                          </li>  
                        @endcan
                        
                    </ul>
                </li>  
              @endcan
               {{-- PERMISO SIDEBAR 1 --}}
               @can('view-rolper', Model::class)
               <li class="nav-header" style="padding-left: 1px;">ADMINISTRACIÓN</li>
               <li class="nav-item">{{-- ACCESO DEL SISTEMA --}}
                   <a href="#" class="nav-link">
                     <i class="nav-icon fas fa-users"></i>
                     <p>
                       ACCESO DEL SISTEMA
                       <i class="fas fa-angle-left right"></i>
                     </p>
                   </a>
                   <ul class="nav nav-treeview" style="display: none;">
                     @can('view-user', Model::class)
                      <li class="nav-item">
                       <router-link class="nav-link" to='/usuarios'>
                         <i class="nav-icon fas fa-users-cog"></i>
                         <p>Usuarios</p>
                       </router-link>
                     </li>
                     @endcan
                     @can('view-rol', Model::class)
                     <li class="nav-item">
                       <router-link class="nav-link" to='/roles'>
                         <i class="nav-icon fas fa-user-clock"></i>
                         <p>Roles</p>
                       </router-link>
                     </li>
                     @endcan
                     @can('view-permi', Model::class)
                     <li class="nav-item">
                       <router-link class="nav-link" to='/permisos'>
                         <i class="nav-icon fas fa-user-edit"></i>
                         <p>Permisos</p>
                       </router-link>
                     </li>
                     @endcan

                   </ul>
               </li>
               @endcan

                {{-- <li class="nav-item">
                    <router-link class="nav-link" to='/ayuda'>
                      <i class="nav-icon fas fa-info-circle"></i>
                      <p>AYUDAS</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" to='/acercade'>
                      <i class="nav-icon fas fa-boxes"></i>
                      <p>ACERCA DE</p>
                    </router-link>
                </li> --}}
              </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->

</aside>
