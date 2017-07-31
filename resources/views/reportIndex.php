<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
</head>
<body>
<div class="container">

    <form class="getReport-form" action="<?= url('/report') ?>">
        <div class="row">
            <div class="form-group col-md-3">
                <label>Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group col-md-5">
                <label>Range</label>
                <div class="input-group input-daterange">
                    <input type="text" class="form-control" name="date-from"
                           data-date-format="yyyy-mm-dd">
                    <div class="input-group-addon">to</div>
                    <input type="text" class="form-control" name="date-to"
                           data-date-format="yyyy-mm-dd">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>

    <div class="reportOutput"></div>

</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js">
</script>
<script>
    $('.input-daterange input').each(function() {
        $(this).datepicker('clearDates');
    });
    $('.getReport-form').submit(function(e) {
        var $this = $(this);
        e.preventDefault();

        $.get($this.attr('action'), $this.serialize())
            .done(function(data) {
                $('.reportOutput').html(data);
            })
            .fail(function(data) {
                $('.reportOutput').html(data.responseText);
            });
    });
</script>
</html>