var $lat1 = $("#lat1"),
        $lat2 = $("#lat2"),
        $lon1 = $("#lon1"),
        $lon2 = $("#lon2");


$("#location1").on("change keyup", function () {
    var location = $(this).val();
    $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address=" + encodeURIComponent(location), function (val) {
        if (val.results.length) {
            var location = val.results[0].geometry.location;
            $lat1.val(location.lat);
            $lon1.val(location.lng);
        }
    });
});

$("#location2").on("focusout", function () {
    var location = $(this).val();
    $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address=" + encodeURIComponent(location), function (val) {
        if (val.results.length) {
            var location = val.results[0].geometry.location;
            $lat2.val(location.lat);
            $lon2.val(location.lng);
            if ($lat1.val() !== null && $lat2.val() !== null && $lon1.val() !== null && $lon2.val() !== null) {
                distance($lat1.val(), $lat2.val(), $lon1.val(), $lon2.val());
            }
        }
    });
});

//$('form#tracker .submitBTN').on("click", function (e) {
//    e.preventDefault();
//});

function distance($lat1, $lat2, $lon1, $lon2) {

    var $radians = Math.PI / 180,
            $lat1rad = $lat1 * $radians,
            $lat2rad = $lat2 * $radians,
            $theta = ($lon1 - $lon2) * $radians,
            $totalDistance = null;
    $totalDistance = (Math.acos(Math.sin($lat1rad) * Math.sin($lat2rad) + Math.cos($lat1rad) * Math.cos($lat2rad) * Math.cos($theta))) * (180 / Math.PI) * 60 * 1.1515;
    console.log($totalDistance.toFixed(0));
    $("#totalDistance").val($totalDistance.toFixed(0));


}