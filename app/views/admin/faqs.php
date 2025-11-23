<div class="page-wrapper">
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">FAQs Management</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
              Add FAQ
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="container-xl">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">FAQs</h3>
        </div>
        <div class="card-body">
          <table class="table table-vcenter">
            <thead>
              <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Type</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($faqs as $faq): ?>
              <tr>
                <td><?= $faq['id'] ?></td>
                <td><?= htmlspecialchars($faq['question']) ?></td>
                <td><?= htmlspecialchars($faq['type']) ?></td>
                <td>
                  <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editFaqModal" onclick="editFaq(<?= $faq['id'] ?>, '<?= addslashes(htmlspecialchars($faq['question'])) ?>', '<?= addslashes($faq['answer']) ?>', '<?= addslashes(htmlspecialchars($faq['type'])) ?>')">Edit</button>
                  <a href="?page=faq_delete&id=<?= $faq['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this FAQ?')">Delete</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal modal-blur fade" id="addFaqModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="?page=faq_save" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" class="form-control" name="question" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <div class="input-group">
              <select class="form-select" name="type" required>
                <?php foreach ($types as $t): ?>
                <option value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></option>
                <?php endforeach; ?>
              </select>
              <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addTypeModal">Add New</button>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Answer</label>
            <textarea class="form-control" name="answer" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal modal-blur fade" id="editFaqModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="?page=faq_update" method="post">
        <input type="hidden" name="id" id="editId">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" class="form-control" name="question" id="editQuestion" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <div class="input-group">
              <select class="form-select" name="type" id="editType" required>
                <?php foreach ($types as $t): ?>
                <option value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></option>
                <?php endforeach; ?>
              </select>
              <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addTypeModal">Add New</button>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Answer</label>
            <textarea class="form-control" name="answer" id="editAnswer" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Type Modal -->
<div class="modal modal-blur fade" id="addTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="?page=faq_addtype" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Type Name</label>
            <input type="text" class="form-control" name="type_name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Type</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function editFaq(id, question, answer, type) {
  document.getElementById('editId').value = id;
  document.getElementById('editQuestion').value = question;
  document.getElementById('editAnswer').value = answer;
  document.getElementById('editType').value = type;
}
</script>
