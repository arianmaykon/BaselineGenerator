<?php
if ($success) {
	echo 'Baseline gerada com sucesso!';
} else {
	echo 'Ocorreu um erro na geração da baseline.';
	var_dump($result);
}