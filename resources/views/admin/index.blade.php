@extends('admin.layouts.main')
@section('content')
      <div class="main-panel">
        <div class="content-wrapper">
         
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Dashboard
            </h3>
            
          </div>
          <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>
                    <h4 class="font-weight-normal mb-3">Hotels
                      <i class="mdi mdi-hotel mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{\App\Hotel::count()}}</h2>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                  
                    <h4 class="font-weight-normal mb-3">Vehicles
                      <i class="mdi mdi-car mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{\App\Vehicle::count()}}</h2>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                                    
                    <h4 class="font-weight-normal mb-3">Tour Packages
                      <i class="mdi mdi-human-handsup mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{\App\TourPackage::count()}}</h2>
                  </div>
                </div>
              </div>
            </div>

            <div class="page-header">
                <h3 class="page-title">
                  <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-home"></i>                 
                  </span>
                  Bookings
                </h3>
                
              </div>

            <div class="row">
                <div class="col-md-4 stretch-card grid-margin">
                  <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                      <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>
                      <h4 class="font-weight-normal mb-3">Hotel Bookings
                        <i class="mdi mdi-hotel mdi-24px float-right"></i>
                      </h4>
                      <h2 class="mb-5">{{\App\Booking::count()}}</h2>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 stretch-card grid-margin">
                  <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                      <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                  
                      <h4 class="font-weight-normal mb-3">Vehicle Bookings
                        <i class="mdi mdi-car mdi-24px float-right"></i>
                      </h4>
                      <h2 class="mb-5">{{\App\VehicleBooking::count()}}</h2>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 stretch-card grid-margin">
                  <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                      <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                                    
                      <h4 class="font-weight-normal mb-3">Tour Package Bookings
                        <i class="mdi mdi-human-handsup mdi-24px float-right"></i>
                      </h4>
                      <h2 class="mb-5">{{\App\TourPackageBooking::count()}}</h2>
                    </div>
                  </div>
                </div>
              </div>
  
          
         
       
@endsection