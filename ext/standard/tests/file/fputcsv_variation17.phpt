--TEST--
fputcsv() with user provided eol
--FILE--
<?php
$data = [
    ['aaa', 'bbb', 'ccc', 'dddd'],
    ['123', '456', '789'],
    ['"aaa"', '"bbb"'],
];

$eol_chars = ['||', '|', '\n', "\n"];
foreach ($eol_chars as $eol_char) {
    $stream = fopen('php://memory', 'w+');
    foreach ($data as $record) {
        fputcsv($stream, $record, ',', '"', '\\', $eol_char);
    }
    rewind($stream);
    echo stream_get_contents($stream), "\n";
    fclose($stream);
}
?>

--EXPECT--
aaa,bbb,ccc,dddd||123,456,789||"""aaa""","""bbb"""||
aaa,bbb,ccc,dddd|123,456,789|"""aaa""","""bbb"""|
aaa,bbb,ccc,dddd\n123,456,789\n"""aaa""","""bbb"""\n
aaa,bbb,ccc,dddd
123,456,789
"""aaa""","""bbb"""
