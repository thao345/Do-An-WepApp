<?php 
<div class="d-flex justify-content-between">

<div class="p-10 mb-3">
    <strong>Page
        <?= $page_no; ?> of
        <?= $total_no_of_pages; ?>
    </strong>
</div>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item <?= ($page_no <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page : ''; ?>>
                Previous
            </a>
        </li>

        <?php
        $start_page = max(1, $page_no - 2);
        $end_page = min($start_page + 4, $total_no_of_pages);

        for ($counter = $start_page; $counter <= $end_page; $counter++) {
            ?>
            <li class="page-item <?php echo ($page_no == $counter) ? 'active' : ''; ?>">
                <a class="page-link" href="?page_no=<?= $counter; ?>">
                    <?= $counter; ?>
                </a>
            </li>
            <?php
        }
        ?>

        <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
            <a class="page-link" <?= ($page_no < $total_no_of_pages) ? 'href=?page_no=' . $next_page : ''; ?>>
                Next
            </a>
        </li>
    </ul>
</nav>
</div>
?>