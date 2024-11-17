<nav class="main-header navbar navbar-expand navbar-light navbar-white">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
       
    </ul>

   {{config('app.name')}}, {{config('app.agency')}}
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">        
        <li class="nav-item">
           

        {!! Form::button('<i class="fa fa-user"></i> Profil',
        ['onclick'=>"window.location='".route('pengurusan.users.profile.show')."'",'class'=>'nav-link btn bg-purle']) !!}

        </li>
         <li class="nav-item">
            <button data-toggle='modal' data-target='#logoutModal' class="nav-link btn bg-purle">
                <i class="fa fa-power-off"></i> Log Keluar
            </button>
        </li>

    </ul>
</nav>
