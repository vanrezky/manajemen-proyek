      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            </div>
          </div>


          <div class="section-body">
            <div class="hero text-white hero-bg-image" data-background="<?= base_url(); ?>public/assets/img/unsplash/eberhard-grossgasteiger-1207565-unsplash.jpg">
              <div class="hero-inner">
                <h2>Welcome, <?= $this->session->userdata('user')['nama']; ?></h2>
                <p class="lead">Selamat datang di aplikasi menejemen proyek <b>PT. Valensi Indonesia Perkasa</b>, Anda login sebagai <?= ucfirst($this->session->userdata('user')['level']); ?></p>
              </div>
            </div>
            <div class="card">
              <div class="card-body">

              </div>
            </div>
          </div>
        </section>
      </div>