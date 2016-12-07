$(function () {
    var $clicked = $('input'),
            $next_button = $('.next_style'),
            $totalPts = $('.total_points'),
            $timePenalty = 0,
            $timerAPI = $('.timer'),
            correct = 0,
            total_answered = 0,
            score = 0,
            points = 200,
            timer = null,
            duration = 30,
            q_pos = 1;

    $timerAPI.text(duration);

    function displayScore(points) {
        var displayScore = '0000',
                maxZeros = 5,
                x = 0;
        if (points >= 0) {
            $totalPts.css('color', 'green');
        } else {
            $totalPts.css('color', 'red');
        }
        displayScore = Math.abs(points);
        displayScore = displayScore.toString();
        while ((displayScore.length - maxZeros) !== 0) {
            displayScore = '0' + displayScore;
        }
        $totalPts.text(displayScore);
    } // End of Display Score Function:

    displayScore(score);

    /*
     * The Timer Function
     */
    function myTimer(sec) {
        var displaySec = null; // This variable is used for HTML display:
        if (timer) {
            clearInterval(timer); // Stop Timer:
        }
        /*
         * The actual timer function, setup and execution.
         */
        timer = setInterval(function () {
            /*
             * Display leading zero if less than 2 digits.
             */
            if (sec < 10) {
                displaySec = "0" + sec;
            } else {
                displaySec = sec;
            }
            /*
             * Display if timer is still running. 
             */
            if (sec !== -1) {
                $timerAPI.text(displaySec);
            }
            if (sec === -1) {
                clearInterval(timer);
                $timerAPI.css('color', 'red');
                score = score - 50;
                $('.target_answer').off('click', check_answer);
                $('label.quizStyle').addClass('restore_background');
                $('label.quizStyle').removeClass('highlight_answer');
                displayScore(score);
                $next_button.show();
                $next_button.on('click', reset_display);
            }
            sec--;
        }, 1000); // End of SetInterval Function:
    } // end of Timer Function:

    function load_questions() {
        var params = {load_questions: 'load'}; // Set parameters:
        var myData = jQuery.param(params); // Set parameters to correct Ajax format:
        $.ajax({
            type: 'post',
            url: 'game_play.php',
            data: myData,
            success: function (data) {
                console.log("data", data);
                $('form#trivia_style').show();
                var num = 0;
                for (var x = 0; x < data.length; x++) {
                    $('.display_q' + (x + 1)).text(data[x].question);

                    $('label.ans' + (num + 1)).text(data[x].answer1);
                    $('label.ans' + (num + 2)).text(data[x].answer2);
                    $('label.ans' + (num + 3)).text(data[x].answer3);
                    $('label.ans' + (num + 4)).text(data[x].answer4);
                    $('input.id_' + (x + 1)).attr('data-id', data[x].id);
                    num += 4;
                }
                $('label.quizStyle').addClass('restore_background');
                $('label.quizStyle').addClass('highlight_answer');
                $('.target_answer').on('click', check_answer);
            },
            error: function (request, status, error) {
                /*
                 * If there is no data in the trivia database then give an error and reload the page.
                 * This usually means that a new day and a new set of question was being "loaded" while
                 * the player started the game.
                 */
                if (request.status === 410) {
                    location.reload();
                }
            }
        }); // End of ajax function:
    } // End of retrieve_question function:

    load_questions();
    $('.target_answer').off('click', check_answer);
    myTimer(duration);

    function check_answer(e) {
        e.preventDefault();
        $('label.quizStyle').addClass('restore_background');
        $('label.quizStyle').removeClass('highlight_answer');
        var answer = $(e.target).val(),
                id = $(e.target).data("id");
        console.log('id', id, 'answer', answer);
        var params = {id: id, answer: answer};
        var myData = jQuery.param(params); // Set parameters to correct Ajax format:
        $.ajax({
            type: 'post',
            url: 'game_play.php',
            data: myData,
            success: function (result) {
                $('.target_answer').off('click', check_answer);
                if (result.correct) {
                    correct += 1;
                    score = score + points;
                    $('label.ans_num' + result.right_answer).addClass('green');
                } else {
                    score = score - (points / 4);
                    $('label.ans_num' + result.right_answer).addClass('green');
                    $('label.ans_num' + result.user_answer).addClass('red');
                }
                clearInterval(timer);
                displayScore(score);
                $next_button.show();
                $next_button.on('click', reset_display);
            },
            error: function (request, status, error) {
                console.log(request, status, error);
                if (request.status === 410) {
                    location.reload();
                }
            }
        }); // End of ajax function:
    } // End of check_answer function:

    function reset_display(e) {
        if (q_pos === 10) {
            $('div.end_of_game').show();
            e.preventDefault(); // Prevent submit button from firing in HTML:
        } else {
            e.preventDefault(); // Prevent submit button from firing in HTML:
            total_answered += 1;
            $timerAPI.css('color', 'green');
            $timerAPI.text(duration);
            myTimer(duration);
            /*
             * Reset display back to original and show the next question and answers.
             */
            $next_button.hide();
            $next_button.off('click', reset_display);

            for (var x = 1; x <= 4; x++) {
                $('label.ans_num' + x).removeClass('green');
                $('label.ans_num' + x).removeClass('red');
            }
            $('label.quizStyle').addClass('highlight_answer');
            $('#question' + q_pos).hide();
            $('.id_' + q_pos).removeClass('target_answer');
            q_pos += 1; // Increment id to next question:

            $('.id_' + q_pos).addClass('target_answer');
            $('#question' + q_pos).show(); // Show new question:

            $('.target_answer').on('click', check_answer);
        }
    } // End of reset_display function:

}); // End of Document Ready: