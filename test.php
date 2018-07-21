<?php
$post='<script>alert(\'fdsafdsa\');</script>';

echo htmlspecialchars($post);
$post=htmlspecialchars($post);
//echo htmlspecialchars_decode($post);
