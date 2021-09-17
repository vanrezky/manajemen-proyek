<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Management Proyek</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">MP</a>
        </div>
        <ul class="sidebar-menu">

            <li class="menu-header">Menu</li>

            <?php
            $break = false;
            foreach ($menu_array as $key => $value) {

                $parent = $value['parent'];
                $uri =  $this->uri->segment(1);
                $activeParent = '';

                if (isset($value['sub'])) {

                    if ($break === false) {
                        foreach ($value['sub'] as $k => $sub) {

                            if ($uri == $sub['url']) {
                                $activeParent = 'active';
                                $break = true;
                                break;
                            }
                        }
                    }

                    echo '<li class="nav-item dropdown ' . $activeParent . '">';
                    echo '<a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="' . $parent['icon'] . '"></i> <span>' . ucwords($parent['nama_menu']) . '</span></a>';
                    echo '<ul class="dropdown-menu">';
                    foreach ($value['sub'] as $k => $sub) {

                        $url = base_url($sub['url']);
                        $activeSub = '';
                        if ($uri == $sub['url']) {
                            $activeSub = 'active';
                        }
                        echo '<li class="' . $activeSub . '"><a class="nav-link" href="' . $url . '">' .  ucwords($sub['nama_menu']) . '</a></li>';
                    }
                    echo '</ul>';
                    echo '</li>';
                } else {
                    $uri = empty($uri) ? '/' : ($uri == 'dashboard' ? '/' : $uri);
                    if ($uri == $parent['url']) {
                        $activeParent = 'active';
                    }
                    echo '<li class="' . $activeParent . '"><a class="nav-link" href="' . base_url($parent['url']) . '"><i class="' . $parent['icon'] . '"></i> <span>' . ucwords($parent['nama_menu']) . '</span></a></li>';
                }
            }
            ?>

        </ul>

    </aside>
</div>