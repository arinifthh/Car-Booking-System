<ul class="sidebar navbar-nav">
      <li class="nav-item <?= $title == 'Dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="main.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item <?= $title == 'Vehicles' ? 'active' : '' ?>">
        <a class="nav-link" href="vehicleview.php">
          <i class="fas fa-fw fa-car"></i>
          <span>Vehicles</span></a>
      </li>

      <li class="nav-item dropdown  <?= $title == 'Bookings' ? 'active' : '' ?>">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-key"></i>
          <span>Bookings</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">My Bookings:</h6>
          <a class="dropdown-item" href="bookingadd.php">Add</a>
          <a class="dropdown-item" href="bookingview.php">Manage</a>
          <a class="dropdown-item" href="bookinghistory.php">History</a>
        </div>
      </li>
    </ul>