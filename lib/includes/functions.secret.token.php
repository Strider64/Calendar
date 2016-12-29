<?php

function generate_secure_token($length = 16) {
    /* important! this has to be a crytographically secure random generator */
    return bin2hex(openssl_random_pseudo_bytes($length));
}
