<div class="page">
  <div class="about-container">
  <div class="about-hero card my-4 position-relative" style="background-image: url('/laptop_store/public/images/about_banner.jpg'); background-size: cover; background-position: center;">
    <div class="card-body p-0">
      <div class="hero-content">
        <div class="text-center text-white">
          <h1 class="display-4 mb-2"><?= htmlspecialchars($settings['about_title'] ?? 'Về chúng tôi') ?></h1>
          <p class="mb-0"><?= htmlspecialchars($settings['about_subtitle'] ?? 'Khám phá câu chuyện và giá trị cốt lõi') ?></p>
        </div>
      </div>
    </div>
    <button class="btn btn-sm btn-outline-primary position-absolute top-0 end-0 m-2" data-bs-toggle="modal" data-bs-target="#editHeroModal">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"/>
        <path d="M16.5 5.5a2.121 2.121 0 0 1 3 3l-10 10l-4 1l1 -4z"/>
      </svg>
    </button>
  </div>

  <div class="row gx-4 gy-4 mb-4 align-items-stretch">
    <div class="col-md-7 position-relative">
      <div class="card about-card h-100">
        <div class="card-body">
          <h3 class="card-title">Sứ mệnh của chúng tôi</h3>
          <div class="card-text"><?= $settings['about_mission'] ?? 'Mission text...' ?></div>
        </div>
      </div>
      <button class="btn btn-sm btn-outline-primary position-absolute top-0 end-0 m-2" data-bs-toggle="modal" data-bs-target="#editMissionModal">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"/>
          <path d="M16.5 5.5a2.121 2.121 0 0 1 3 3l-10 10l-4 1l1 -4z"/>
        </svg>
      </button>
    </div>
    <div class="col-md-5 position-relative">
      <div class="card about-card h-100">
        <div class="card-body d-flex flex-column">
          <h4 class="card-title">Giá trị cốt lõi</h4>
          <div class="about-values-list"><?= $settings['about_values'] ?? '<ul><li>Values...</li></ul>' ?></div>
        </div>
      </div>
      <button class="btn btn-sm btn-outline-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#editValuesModal">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"/>
          <path d="M16.5 5.5a2.121 2.121 0 0 1 3 3l-10 10l-4 1l1 -4z"/>
        </svg>
    </button>
    </div>
  </div>

  <div class="about-page-creators mb-5">
    <h4 class="card-title">Đội ngũ sáng lập</h4>
    <div class="creators-grid">
      <?php foreach ($creators as $c): ?>
        <div class="creator-card position-relative">
          <?php
            $imgPath = __DIR__ . '/../../public/images/creator' . $c['id'] . '.jpg';
            $ver = file_exists($imgPath) ? filemtime($imgPath) : time();
          ?>
          <img src="/laptop_store/public/images/creator<?= $c['id'] ?>.jpg?v=<?= $ver ?>" alt="<?= htmlspecialchars($c['name']) ?>" class="avatar avatar-xl mb-3 rounded-circle">
          <h5 class="mb-1"><?= htmlspecialchars($c['name']) ?></h5>
          <div class="text-muted mb-2"><?= htmlspecialchars($c['role']) ?></div>
          <p class="small text-muted"><?= htmlspecialchars($c['bio']) ?></p>
          <button class="btn btn-sm btn-outline-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#editCreatorModal<?= $c['id'] ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"/>
              <path d="M16.5 5.5a2.121 2.121 0 0 1 3 3l-10 10l-4 1l1 -4z"/>
            </svg>
        </button>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  </div>

<div class="modal modal-blur fade" id="editHeroModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Chỉnh sửa Hero</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <form action="?page=admin_about_update" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Ảnh Banner</label><input type="file" name="banner_image" class="form-control" accept="image/*"></div>
          <div class="mb-3"><label class="form-label">Tiêu đề</label><input type="text" name="about_title" class="form-control" value="<?= htmlspecialchars($settings['about_title'] ?? '') ?>" required></div>
          <div class="mb-3"><label class="form-label">Phụ đề</label><input type="text" name="about_subtitle" class="form-control" value="<?= htmlspecialchars($settings['about_subtitle'] ?? '') ?>" required></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn me-auto" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Lưu</button></div>
      </form>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="editMissionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Chỉnh sửa sứ mệnh</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <form action="?page=admin_about_update" method="post">
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Nội dung sứ mệnh</label><textarea name="about_mission" class="form-control summernote" required><?= htmlspecialchars($settings['about_mission'] ?? '') ?></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn me-auto" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Lưu</button></div>
      </form>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="editValuesModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Chỉnh sửa giá trị</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <form action="?page=admin_about_update" method="post">
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Danh sách giá trị (HTML)</label><textarea name="about_values" class="form-control summernote" required><?= htmlspecialchars($settings['about_values'] ?? '') ?></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn me-auto" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Lưu</button></div>
      </form>
    </div>
  </div>
</div>

<?php foreach ($creators as $c): ?>
<div class="modal modal-blur fade" id="editCreatorModal<?= $c['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Sửa Creator #<?= $c['id'] ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <form action="?page=admin_about_update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="creator_id" value="<?= $c['id'] ?>">
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Tên</label><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($c['name']) ?>" required></div>
          <div class="mb-3"><label class="form-label">Vai trò</label><input type="text" name="role" class="form-control" value="<?= htmlspecialchars($c['role']) ?>" required></div>
          <div class="mb-3"><label class="form-label">Tiểu sử</label><textarea name="bio" class="form-control" required><?= htmlspecialchars($c['bio']) ?></textarea></div>
          <div class="mb-3"><label class="form-label">Ảnh đại diện</label><input type="file" name="profile_image" class="form-control" accept="image/*"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn me-auto" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Cập nhật</button></div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>


<script>
$(document).ready(function(){
  $('.summernote').summernote({
    height: 180,
    toolbar: [
      ['style', ['bold','italic','underline','clear']],
      ['insert', ['link','picture']],
      ['view', ['codeview']]
    ],
    dialogsInBody: true,
    lang: 'vi-VN'
  });
  $(document).on('shown.bs.modal', '.note-modal', function(){
    $(this).css('z-index', 1062);
    $('.modal-backdrop').not('.modal-stack').last().css('z-index', 1061);
  });

  $(document).on('hidden.bs.modal', '.note-modal', function(){
    if ($('.modal.show').length) {
      $('body').addClass('modal-open');
    }
  });

  $('#editValuesModal form').on('submit', function(){
    var editor = $('#editValuesModal .summernote');
    var code = editor.summernote('code');
    try {
      var parser = new DOMParser();
      var doc = parser.parseFromString(code, 'text/html');
      doc.querySelectorAll('ul,ol').forEach(function(list){
        list.classList.add('list-group','list-group-flush');
      });
      doc.querySelectorAll('li').forEach(function(li){
        li.classList.add('list-group-item');
      });
      var out = '';
      doc.body.childNodes.forEach(function(n){ out += n.outerHTML || n.textContent; });
      $('#editValuesModal textarea[name="about_values"]').val(out);
    } catch (e) {
      // fallback: leave content as-is
    }
  });
});
// make the close button in deeper modals use the same class as <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
$(function(){
  $(document).on('shown.bs.modal', function(e){
    $(e.target).find('.modal-header .close').each(function(){
      $(this).addClass('btn-close').removeClass('close').attr('aria-label','Close').html('').on('click', function(){
        $(this).closest('.modal').modal('hide');
      });
    });
  });
});
</script>
