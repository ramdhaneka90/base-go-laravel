<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"              => "Field :attribute harus disetujui.",
	"active_url"            => "Field :attribute bukan valid URL.",
	"after"                 => "Field :attribute harus berupa tanggal setelah :date.",
	"alpha"                 => "Field :attribute hanya boleh berupa kata.",
	"alpha_dash"            => "Field :attribute hanya boleh berupa kata, nomor, and penghubung.",
	"alpha_num"             => "Field :attribute hanya boleh berupa kata and nomor.",
	"array"                 => "Field :attribute harus berupa array.",
	"before"                => "Field :attribute harus berupa tanggal sebelum :date.",
	"between"               => array(
		"numeric"           => "Field :attribute harus diantara :min - :max.",
		"file"              => "Field :attribute harus diantara :min - :max KB.",
		"string"            => "Field :attribute harus diantara :min - :max karakter.",
		"array"             => "Field :attribute harus diantara :min and :max items.",
	),
	"boolean"               => "Field :attribute harus berupa true atau false",
	"confirmed"             => "Field :attribute konfirmasi tidak cocok.",
	"date"                  => "Field :attribute bukan tanggal valid.",
	"date_format"           => "Field :attribute tidak cocok dengan format :format.",
	"different"             => "Field :attribute dan :other harus berbeda.",
	"digits"                => "Field :attribute harus berupa :digits digit.",
	"digits_between"        => "Field :attribute harus di antara :min and :max digit.",
	"email"                 => "Field :attribute bukan berupa valid email.",
	"filled"               	=> "Field :attribute harus diisi.",
	"exists"                => "Field terpilih :attribute tidak valid.",
	"image"                 => "Field :attribute harus berupa gambar.",
	"in"                    => "Field selected :attribute tidak valid.",
	"integer"               => "Field :attribute harus berupa integer.",
	"ip"                    => "Field :attribute harus berupa IP address.",
	"max"                   => array(
		"numeric"           => "Field :attribute tidak boleh lebih dari :max.",
		"file"              => "Field :attribute tidak boleh lebih dari :max KB.",
		"string"            => "Field :attribute tidak boleh lebih dari :max karakter.",
		"array"             => "Field :attribute tidak boleh lebih dari :max items.",
	),
	"mimes"                 => "Field :attribute harus berupa file: :values.",
	"min"                   => array(
		"numeric"           => "Field :attribute harus lebih dari :min.",
		"file"              => "Field :attribute harus lebih dari :min KB.",
		"string"            => "Field :attribute harus lebih dari :min karakter.",
		"array"             => "Field :attribute harus paling tidak :min items.",
	),
	"not_in"                => "Field selected :attribute tidak valid.",
	"numeric"               => "Field :attribute harus berupa angka.",
	"regex"                 => "Field :attribute format tidak valid.",
	"required"              => "Field :attribute harus diisi.",
	"required_if"           => "Field :attribute harus diisi ketika :other adalah :value.",
	"required_with"         => "Field :attribute harus diisi ketika :values ada.",
	"required_with_all"     => "Field :attribute harus diisi ketika :values tidak ada.",
	"required_without"      => "Field :attribute harus diisi ketika :values tidak ada.",
	"required_without_all"  => "Field :attribute harus diisi ketika :values tidak ada.",
	"same"                  => "Field :attribute and :other harus sama.",
	"size"                  => array(
		"numeric"           => "Field :attribute harus :size.",
		"file"              => "Field :attribute harus :size KB.",
		"string"            => "Field :attribute harus :size karakter.",
		"array"             => "Field :attribute harus berisi :size items.",
	),
	"unique"                => "Field :attribute sudah ada.",
	"must_unique"           => "Field :attribute harus unik.",
	"url"                   => "Field :attribute format tidak valid.",
	"timezone"              => "Field :attribute timezone tidak valid.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
