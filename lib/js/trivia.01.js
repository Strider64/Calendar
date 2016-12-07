$(function () {
    var id = null,
            $question = $('.displayQuest'),
            $answer1 = $('.answer1'),
            $answer2 = $('.answer2'),
            $answer3 = $('.answer3'),
            $answer4 = $('.answer4'),
            $answerBtn = $('.checked'),
            $startBtn = $('.startBtn'),
            $nextBtn = $('.nextBtn'),
            totalCorrect = 0,
            timer = null,
            timeLeft = 0,
            $timerAPI = $('.showTimer'),
            duration = 30,
            player = $('.caption').text(),
            profile_picture = $('.fb-profile-picture').attr('src'),
            category = "movieTrivia",
            ids = [],
            no_data = false,
            daily_ten = [];

    /*
     * Check to see if player is in players database table
     */
    function checkPlayer() {
        var params = {player: player};
        var myData = jQuery.param(params); // Set parameters to corret AJAX format;
        $.ajax({
            type: 'post',
            url: 'triviaAjaxPHP_01.php',
            data: myData,
            success: function (result) {
                if (result.info === 'read') {
                    // daily_ten = result[0];
                    //console.log('daily_ten array', daily_ten);
                    console.log('checkPlayer:', result);
                }

                if (result.info === 'insert') {
                    insertPlayer();
                    checkPlayer();
                }

            },
            error: function (request, status, error) {
                if (request.responseJSON.type === 'fail') {
                    console.log('fail');
                }
            }
        }); // End of Ajax Function:
    }


    function insertPlayer() {
        var params = {player: player, profile_picture: profile_picture};
        var myData = jQuery.param(params); // Set parameters to correct AJAX format:
        $.ajax({
            type: 'post',
            url: 'triviaAjaxPHP_01.php',
            data: myData,
            success: function (result) {
                console.log('result', result.type);
            },
            error: function (request, status, error) {
                if (request.responseJSON.type === 'fail') {
                    console.log('fail');
                }
            }
        }); // End of Ajax Function:        
    }

    if (player !== "") {
        checkPlayer();
    }


    function readQuestion() {

        var params = {id: 3};
        var myData = jQuery.param(params); // Set parameters to corret AJAX format;
        $.ajax({
            type: 'post',
            url: 'triviaAjaxPHP_01.php',
            data: myData,
            success: function (result) {
                id = result.id;
                $question.text(id + '. ' + result.question);
                $answer1.text(result.answer1);
                $answer2.text(result.answer2);
                $answer3.text(result.answer3);
                $answer4.text(result.answer4);
            },
            error: function (request, status, error) {
                if (request.responseJSON.type === 'fail') {
                    $('.triviaBackground').hide();
                }
            }
        }); // End of Ajax Function:
    }

}); // End of Doc Ready Function: