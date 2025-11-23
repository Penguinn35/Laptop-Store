<div class="page">
  <div class="container-xl">
    <div class="faq-page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <h1 class="faq-page-title">
            Câu Hỏi Thường Gặp
          </h1>
        </div>
      </div>
    </div>
    
    <?php
    $grouped = [];
    foreach ($faqs as $faq) {
        $grouped[$faq['type']][] = $faq;
    }
    $globalIndex = 0;
    foreach ($grouped as $type => $questions):
    ?>
    <div class="hr-text hr-text-center mb-4"><?= htmlspecialchars($type) ?></div>
    <div class="mb-5">
      <div class="accordion" id="faqAccordion-<?= htmlspecialchars($type) ?>">
        <?php
        $groupIndex = 0;
        foreach ($questions as $faq):
        ?>
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading<?= $globalIndex ?>">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $globalIndex ?>" aria-expanded="false" aria-controls="collapse<?= $globalIndex ?>">
              <div class="accordion-button-toggle accordion-button-toggle-plus">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                  <path d="M12 5l0 14"></path>
                  <path d="M5 12l14 0"></path>
                </svg>
              </div>
              <?= htmlspecialchars($faq['question']) ?>
            </button>
          </h2>
          <div id="collapse<?= $globalIndex ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $globalIndex ?>" data-bs-parent="#faqAccordion-<?= htmlspecialchars($type) ?>">
            <div class="accordion-body">
              <?= nl2br(htmlspecialchars($faq['answer'])) ?>
            </div>
          </div>
        </div>
        <?php
        $globalIndex++;
        $groupIndex++;
        endforeach;
        ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>