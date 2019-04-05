<?php include('./part/header.php')?>
<?php include('./part/template.php') ?>
<?php include('./service/data.php')?>

<main id="calendar" role="main">

    <header id="header">
        <h1>
        <time id="month-year" data-year="<?=date('Y')?>" data-month="<?=date('m')?>"><?= date('m') ?> <?= date('Y') ?></time>
        </h1>
    </header>

    <section id="days" class="clearfix">
        <div class="day">SUN</div>
        <div class="day">MON</div>
        <div class="day">TUE</div>
        <div class="day">WED</div>
        <div class="day">THU</div>
        <div class="day">FRI</div>
        <div class="day">SAT</div>
    </section>

    <section id="dates" class="clearfix">
        <?php foreach($dates as $key => $date): ?>
            <div class="date-block <?= (is_null($date))? 'empty':'' ?>" data-date="<?= $date ?>">
                <div class="date"><?= $date ?></div>
                <div class="events">
                    <div class="event clearfix" data-id="<?=$date?>">
                        <div class="title">Title</div>
                        <div class="from">10:00</div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </section>

</main>

<aside id="panel" class="update">
    <section class="close">X</section>
    <form>
        <section class="title">
            <label>Event Name:</label>
            <input type="text" name="title" placeholder="Title" required>
        </section>
        <section class="time-picker">
            <div class="selected-date">
                <input type="hidden" name="year">
                <input type="hidden" name="month">
                <input type="hidden" name="date">
                <time><span class="date">20</span> <span class="month">Oct</span></time>
            </div>
            <section class="from">
                <label>From:</label><br>
                <input type="time" name="start" required>
            </section>
            <section class="to">
                <label>To:</label><br>
                <input type="time" name="end" required>
            </section>
        </section>
        <section class="description">
            <label>Description:</label><br>
            <textarea name="description" id="description" placeholder="Description" required></textarea>
        </section>    
    </form> 
        <section class="buttons clearfix">
            <button class="create" style="background: green;">Create</button>
            <button class="update"  style="background: blue;">Update</button>
            <button class="cancel"  style="background: grey;">Cancel</button>
            <button class="delete"  style="background: red;">Delete</button>        
        </section>   
</aside>

<?php include('./part/footer.php')?>