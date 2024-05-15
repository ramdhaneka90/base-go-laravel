<style>
table {
	border-collapse: collapse;
	page-break-inside: auto;
	width: 100%;
}
tr {
	page-break-inside: avoid;
}

table, td, th {
	border: 1px solid black;
}

table th {
	text-align: center;
	background-color: #e9ecef;
}

table td {
	vertical-align: baseline;
}

thead th.border-spec{
	border-top: 2px solid #000000;
	border-bottom: 2px solid #000000;
}

table,td.noborder{
	border: none !important;
}

hr{
	border: 1px solid #5f5f5f;
}

@media print {
	.no-print {
		display: none;
	}

	.print-only{
		display: block;
	}
}

.col-print-1 {width:8%;  float:left;}
.col-print-2 {width:16%; float:left;}
.col-print-3 {width:25%; float:left;}
.col-print-4 {width:33%; float:left;}
.col-print-5 {width:42%; float:left;}
.col-print-6 {width:50%; float:left;}
.col-print-7 {width:58%; float:left;}
.col-print-8 {width:66%; float:left;}
.col-print-9 {width:75%; float:left;}
.col-print-10{width:83%; float:left;}
.col-print-11{width:92%; float:left;}
.col-print-12{width:100%; float:left;}

.text-left {text-align: left !important; }
.text-right {text-align: right !important; }
.text-center {text-align: center !important; }
.text-justify {text-align: justify !important; }
.font-weight-bold { font-weight: bold !important; }

/* border */
.border{ border: 1px solid }
.border-success{ border-color: green; }

.padding-xs { padding: .25em; }
.padding-sm { padding: .5em; }
.padding-md { padding: 1em; }
.padding-lg { padding: 1.5em; }
.padding-xl { padding: 3em; }

.padding-x-xs { padding: .25em 0; }
.padding-x-sm { padding: .5em 0; }
.padding-x-md { padding: 1em 0; }
.padding-x-lg { padding: 1.5em 0; }
.padding-x-xl { padding: 3em 0; }

.padding-y-xs { padding: 0 .25em; }
.padding-y-sm { padding: 0 .5em; }
.padding-y-md { padding: 0 1em; }
.padding-y-lg { padding: 0 1.5em; }
.padding-y-xl { padding: 0 3em; }

.padding-top-xs { padding-top: .25em; }
.padding-top-sm { padding-top: .5em; }
.padding-top-md { padding-top: 1em; }
.padding-top-lg { padding-top: 1.5em; }
.padding-top-xl { padding-top: 3em; }

.padding-right-xs { padding-right: .25em; }
.padding-right-sm { padding-right: .5em; }
.padding-right-md { padding-right: 1em; }
.padding-right-lg { padding-right: 1.5em; }
.padding-right-xl { padding-right: 3em; }

.padding-bottom-xs { padding-bottom: .25em; }
.padding-bottom-sm { padding-bottom: .5em; }
.padding-bottom-md { padding-bottom: 1em; }
.padding-bottom-lg { padding-bottom: 1.5em; }
.padding-bottom-xl { padding-bottom: 3em; }

.padding-left-xs { padding-left: .25em; }
.padding-left-sm { padding-left: .5em; }
.padding-left-md { padding-left: 1em; }
.padding-left-lg { padding-left: 1.5em; }
.padding-left-xl { padding-left: 3em; }

.margin-xs { margin: .25em; }
.margin-sm { margin: .5em; }
.margin-md { margin: 1em; }
.margin-lg { margin: 1.5em; }
.margin-xl { margin: 3em; }

.margin-x-xs { margin: .25em 0; }
.margin-x-sm { margin: .5em 0; }
.margin-x-md { margin: 1em 0; }
.margin-x-lg { margin: 1.5em 0; }
.margin-x-xl { margin: 3em 0; }

.margin-y-xs { margin: 0 .25em; }
.margin-y-sm { margin: 0 .5em; }
.margin-y-md { margin: 0 1em; }
.margin-y-lg { margin: 0 1.5em; }
.margin-y-xl { margin: 0 3em; }

.margin-top-xs { margin-top: .25em; }
.margin-top-sm { margin-top: .5em; }
.margin-top-md { margin-top: 1em; }
.margin-top-lg { margin-top: 1.5em; }
.margin-top-xl { margin-top: 3em; }

.margin-right-xs { margin-right: .25em; }
.margin-right-sm { margin-right: .5em; }
.margin-right-md { margin-right: 1em; }
.margin-right-lg { margin-right: 1.5em; }
.margin-right-xl { margin-right: 3em; }

.margin-bottom-xs { margin-bottom: .25em; }
.margin-bottom-sm { margin-bottom: .5em; }
.margin-bottom-md { margin-bottom: 1em; }
.margin-bottom-lg { margin-bottom: 1.5em; }
.margin-bottom-xl { margin-bottom: 3em; }

.margin-left-xs { margin-left: .25em; }
.margin-left-sm { margin-left: .5em; }
.margin-left-md { margin-left: 1em; }
.margin-left-lg { margin-left: 1.5em; }
.margin-left-xl { margin-left: 3em; }

.bg-lighgray{ background-color:lightgray !important;}
.bg-lightskyblue{ background-color: lightskyblue !important; }
.bg-lighgreen{ background-color: #99ff99 !important; }

.text-cadetblue{color: cadetblue !important;}
.text-lightskyblue{color: lightskyblue !important;}

.align-middle { vertical-align: middle !important; }
.align-baseline { vertical-align: baseline !important; }

.text-danger{ color: #ff3366 !important; }
.text-success{ color: #10b759 !important; }
.text-warning{ color: #ffc107 !important; }

h5 p{ line-height: 0.5em !important;}

</style>