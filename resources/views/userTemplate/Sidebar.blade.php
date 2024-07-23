<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

      @if (hasPermissions('Dashboard'))
          <li class="nav-item {{request()->segments()==null?'active':''}}">
              <a class="nav-link collapsed" href="{{ route('dashboard') }}">
                  <i class="bi bi-grid"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->
      @endif

      {{-- Role Section (Collapsed for demonstration) --}}
      {{-- @if (hasPermissions('Role'))
      <li class="nav-item {{request()->segments()!= null? request()->segments()[0]=='user1234567899'?'active':'':''}}">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Role</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Role</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Add User</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>As User</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>User</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->
      @endif --}}

      <!-- Pages Heading -->
      <li class="nav-heading">Pages</li>

      <!-- User Section -->
      @if (hasPermissions('User'))
          <li class="nav-item {{request()->segments()!= null? request()->segments()[0]=='user'?'active':'':''}}">
              <a class="nav-link collapsed" href="{{ route('user.index') }}">
                  <i class="bi bi-person"></i>
                  <span>User</span>
              </a>
          </li>
      @endif

      <!-- Role Section -->
      @if (hasPermissions('Role'))
          <li class="nav-item {{request()->segments()!= null? request()->segments()[0]=='role'?'active':'':''}}">
              <a class="nav-link collapsed" href="{{ route('role.index') }}">
                  <i class="ri-admin-line"></i>
                  <span>Role</span>
              </a>
          </li>
      @endif

      <!-- Role & Permission Section -->
      @if (hasPermissions('Role permission'))
          <li class="nav-item {{request()->segments()!= null? request()->segments()[0]=='role-permission'?'active':'':''}}">
              <a class="nav-link collapsed" href="{{ route('role-permission.index') }}">
                  <i class="ri-key-2-line"></i>
                  <span>Role & permission</span>
              </a>
          </li>
      @endif

      <!-- Permission Section -->
      @if (hasPermissions('Permission'))
          <li class="nav-item {{request()->segments()!= null? request()->segments()[0]=='permission'?'active':'':''}}">
              <a class="nav-link collapsed" href="{{ route('permission.index') }}">
                  <i class="ri-git-repository-private-line"></i>
                  <span>Permission</span>
              </a>
          </li>
      @endif

  </ul>
</aside><!-- End Sidebar -->
