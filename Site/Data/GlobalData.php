<?php
$APP_VERSION_MAJOR = 0;
$APP_VERSION_MIDDLE = 3;
$APP_VERSION_MINOR = 0;
$APP_PATCH = 0;

$CONN_ENCODING = "utf8";

$DEBUG = FALSE;

$DEFAULT_LOG_FILE="Log.txt";

$DEFAULT_LOG_PATH="Logs";

$CURRENCY = "EURO";

$CURRENCY_SYMBOL = "&#x20AC";

$CURRENCY_DECIMAL_PRECISION = 3;

$AVAILABLE = 
[
    'SHOW' => 1,
    'HIDE' => 2
];

$ACCESS = 
[
    'ADMIN' => 1,
    'CEO' => 2,
    'EMPLOYEE' => 3,
    'GUEST' => 4
];

$MENU = 
[
    'ERROR' => ["TITLE" => "Error", "INDEX" => -1],
    'COMPANY' => ["TITLE" => "Company", "INDEX" => 0],
    'COUNTRY' => ["TITLE" => "Country", "INDEX" => 1],
    'EMPLOYEE' => ["TITLE" => "Employee", "INDEX" => 2],
    'EMPLOYEE_POSITION' => ["TITLE" => "Employee Position", "INDEX" => 3],
    'JOB' => ["TITLE" => "Job", "INDEX" => 4],
    'SHAREHOLDER' => ["TITLE" => "Shareholder", "INDEX" => 5],
    'CUSTOMER' => ["TITLE" => "Customer", "INDEX" => 6],
    'COUNTY' => ["TITLE" => "County", "INDEX" => 7]
];

$MODULE = 
[
    'ADD' => 0,
    'EDIT' => 1,
    'DELETE' => 2,
    'EXTEND' => 3
];

//The index contains the name value that will appear in the HTML selector document
$COMPANY_SEARCH_TYPE = 
[
    "COMPANY_TITLE" => ["NAME" => "Company", "VALUE" => "Company"],
    "COUNTRY_TITLE" => ["NAME" => "Country", "VALUE" => "Country"],
    "COUNTY_TITLE" => ["NAME" => "County", "VALUE" => "County"],
    "COMPANY_DATE" => ["NAME" => "Date", "VALUE" => "Date"],
    "COUNTY_TAX" => ["NAME" => "Tax", "VALUE" => "Tax"],
    "COUNTY_IR" => ["NAME" => "Interest", "VALUE" => "Interest Rate"]
];

$COUNTRY_SEARCH_TYPE = 
[
    "COUNTRY_TITLE" => ["NAME" => "Country", "VALUE" => "Country"]
];

$COUNTY_SEARCH_TYPE = 
[
    "COUNTY_TITLE" => ["NAME" => "Country", "VALUE" => "County"],
    "COUNTY_TAX" => ["NAME" => "Tax", "VALUE" => "Tax"],
    "COUNTY_IR" => ["NAME" => "Interest", "VALUE" => "Interest Rate"]
];

$CUSTOMER_SEARCH_TYPE = 
[
    "CUSTOMER_NAME" => ["NAME" => "Name", "VALUE" => "Name"],
    "CUSTOMER_SURNAME" => ["NAME" => "Surname", "VALUE" => "Surname"],
    "CUSTOMER_PHONE" => ["NAME" => "Phone", "VALUE" => "Phone Number"],
    "CUSTOMER_STABLE" => ["NAME" => "Stable", "VALUE" => "Stable Number"],
    "CUSTOMER_EMAIL" => ["NAME" => "Email", "VALUE" => "Email"],
    "CUSTOMER_VAT" => ["NAME" => "VAT", "VALUE" => "VAT"]
];

$EMPLOYEE_SEARCH_TYPE = 
[
    "EMPLOYEE_NAME" => ["NAME" => "Name", "VALUE" => "Name"],
    "EMPLOYEE_SURNAME" => ["NAME" => "Surname", "VALUE" => "Surname"],
    "EMPLOYEE_EMAIL" => ["NAME" => "Email", "VALUE" => "Email"],
    "EMPLOYEE_BIRTH_DATE" => ["NAME" => "BirthDate", "VALUE" => "Birth Date"],
    "EMPLOYEE_PHONE" => ["NAME" => "Phone", "VALUE" => "Phone Number"],
    "EMPLOYEE_STABLE" => ["NAME" => "Stable", "VALUE" => "Stable Number"],
    "EMPLOYEE_TITLE" => ["NAME" => "Title", "VALUE" => "Title"],
    "EMPLOYEE_SALARY" => ["NAME" => "Salary", "VALUE" => "Salary"]
];

$EMPLOYEE_POSITION_SEARCH_TYPE = 
[
    "EMPLOYEE_POSITION_TITLE" => ["NAME" => "Title", "VALUE" => "Title"]
];

$JOB_ASSIGMENT_SEARCH_TYPE = [];

$JOB_SEARCH_TYPE = 
[
    "JOB_TITLE" => ["NAME" => "Title", "VALUE" => "Title"],
    "JOB_DATE" => ["NAME" => "Date", "VALUE" => "Date"],
    "JOB_PRICE" => ["NAME" => "Price", "VALUE" => "Price"],
    "JOB_PIA" => ["NAME" => "PIA", "VALUE" => "Payment In Advance"],
    "JOB_EXPENSES" => ["NAME" => "Expenses", "VALUE" => "Expenses"],
    "JOB_DAMAGE" => ["NAME" => "Damage", "VALUE" => "Damage"],
    "JOB_COMPANY_TITLE" => ["NAME" => "CompanyTitle", "VALUE" => "Company Name"]
];

$SHAREHOLDER_SEARCH_TYPE = 
[
    "SHAREHOLDER_NAME" => ["NAME" => "Name", "VALUE" => "Name"],
    "SHAREHOLDER_SURNAME" => ["NAME" => "Surname", "VALUE" => "Surname"],
    "SHAREHOLDER_EMAIL" => ["NAME" => "Email", "VALUE" => "Email"],
    "SHAREHOLDER_BIRTH_DATE" => ["NAME" => "Date", "VALUE" => "Birth day Date"],
    "SHAREHOLDER_POSITION_TITLE" => ["NAME" => "PositionTitle", "VALUE" => "Position Title"],
    "SHAREHOLDER_SALARY" => ["NAME" => "Salary", "VALUE" => "Salary"]
];

$AVAILABLE_ARRAY_SIZE = count($GLOBALS['AVAILABLE']);

$ACCESS_ARRAY_SIZE = count($GLOBALS['ACCESS']);

$MENU_INDEX_ARRAY_SIZE = count($GLOBALS['ACCESS']);
?>
