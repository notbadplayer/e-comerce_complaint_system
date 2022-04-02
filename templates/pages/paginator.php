<div>
    <?php
    $page = $params['page'] ?? [];
    $pagesize = $page['size'] ?? 10;
    $currentPage = $page['number'] ?? 1;
    $pages = $page['pages'] ?? 1;
    $paginationUrl = "&pagesize=$pagesize&sortBy=" . ($params['sort']['sortBy'] ?? 'id') . "&order=" . ($params['sort']['order'] ?? 1);
    ?>
    <div class="d-flex flex-row flex-wrap justify-content-center justify-content-md-start">
        <div>
            <ul class="pagination pagination-sm">
                <?php if ($currentPage !== 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="/?page=<?php echo $currentPage - 1 . $paginationUrl ?>">
                            <i class="fas fa-chevron-left"></i><span class="d-none d-sm-inline d-md-none ms-1">Poprzednia</span>
                        </a>
                    </li>
                <?php endif; ?>

                <div class="d-none d-md-inline-flex flex-wrap">
                    <?php for ($i = 1; $i <= $pages; $i++) : ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'page-item active' : '' ?>">
                            <a class="page-link" href="/?page=<?php echo $i . $paginationUrl ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </div>
                <li class="page-item d-md-none m-2 lh-1">
                    <span class="text-muted"><?php echo 'Strona ' . $currentPage . ' z ' . $pages; ?></span>
                </li>

                <?php if ($currentPage !== $pages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="/?page=<?php echo $currentPage + 1 . $paginationUrl ?>">
                            <span class="d-none d-sm-inline d-md-none me-1">Następna</span><i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="col-3 col-md-2 col-xl-1 ms-3">
            <form action="/" method="GET">
                <input type="hidden" name="action" value="<?php echo $paginatorRedirect; ?>"/>
                <select name="pagesize" id="pagesize" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="30" <?php echo (isset($pagesize) && $pagesize == "30" ? "selected" : "") ?>>30</option>
                    <option value="50" <?php echo (isset($pagesize) && $pagesize == "50" ? "selected" : "") ?>>50</option>
                    <option value="100" <?php echo (isset($pagesize) && $pagesize == "100" ? "selected" : "") ?>>100</option>
                </select>
            </form>
        </div>
    </div>
</div>