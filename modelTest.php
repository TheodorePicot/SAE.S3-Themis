<?php
use League\CommonMark\CommonMarkConverter;

$output = (new CommonMarkConverter())->convert('# Heading 1')->getContent();