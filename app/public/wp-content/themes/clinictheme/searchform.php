<form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); /* Security: Whenever manually echoing from the database. Prevents hacked website from endangering users */ ?>">
    <label class="headline headline--medium" for="s">Perform a New Search:</label>
    <div class="search-form-row">
        <input placeholder="Write your search here..." class="s" id="s" type="search" name="s">
        <input clas="search-submit" type="submit" value="Search">
    </div>
</form>