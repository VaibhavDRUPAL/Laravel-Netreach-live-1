<?php

// Operators
const DOT = '.';
const STAR = '*';
const F_SLASH = '/';
const NORMAL_SPACE = ' ';
const UNDERSCORE = '_';
const TENDS_TO = '->';

// Extra
const SLUG_DICTIONARY = [
    '@' => 'at',
    '/' => 'or',
    '&' => 'and',
    '#' => 'hash',
    '.' => 'dot',
    '*' => 'star',
    ',' => 'comma',
    '+' => 'plus'
];

// Extras
const STATUS = 'status';
const DATA = 'data';
const COUNT = 'count';
const ADD_ON = 'add_on';
const INDEX = 'index';
const FIELD_TYPE = 'field_type';
const LIMIT = 'limit';
const OFFSET = 'offset';

// Status Code
const OK = 200;
const VALIDATION_ERROR = 600;

// Media Types
const IMAGE = 'image';
const VIDEO = 'video';
const PLAIN_TEXT = 'plain_text';
const HTML = 'html';
const AUDIO = 'audio';
const LINK = 'link';

// Input Types
const IN_TEXT = 'text';
const IN_SELECT = 'select';
const IN_RADIO = 'radio';
const IN_CHECKBOX = 'checkbox';

// RegEx Pattern
const MOB_REGEX = '/^\b[6789][0-9]{9}\b$/i';

// Method
const GET = 'GET';
const POST = 'POST';

// Status Codes for record insert, update and Get
const CREATE_RECORD = 0;
const UPDATE_RECORD = 1;

// Profile Status
const PROFILE_STATUS = [
    0 => 'Not Submitted',
    1 => 'Pending',
    2 => 'Accept',
    3 => 'Rejected'
];

// Region
const REGION = [
    1 => 'North',
    2 => 'South',
    3 => 'East',
    4 => 'West'
];

// Role
const SUPER_ADMIN = 'super-admin';
const PO_PERMISSION = 'PO-Permission';
const VN_USER_PERMISSION = 'VN User Permission';
const COUNSELLOR_PERMISSION = 'Counsellor-Permission';
const CENTER_USER = 'Center User';
const NETREACH_PEER = 'Netreach Peer';
const CBO_PARTNER = 'CBO Partner';

// Services

const SERVICES_VIEW = [
    1 => 'surveyAppointment.HIV Test',
    2 => 'surveyAppointment.STI Services',
    3 => 'surveyAppointment.Pre-Exposure Prophylaxis (PrEP)',
    4 => 'surveyAppointment.PEP',
    5 => 'surveyAppointment.Counselling on Mental Health',
    6 => 'surveyAppointment.Referral to TI services',
    7 => 'surveyAppointment.ART Linkages',
];



// const SERVICES = [
//     1 => 'surveyAppointment.HIV Test',
//     2 => 'surveyAppointment.STI Services',
//     3 => 'surveyAppointment.Pre-Exposure Prophylaxis (PrEP)',
//     4 => 'surveyAppointment.PEP',
//     5 => 'surveyAppointment.Counselling on Mental Health',
//     6 => 'surveyAppointment.Referral to TI services',
//     7 => 'surveyAppointment.ART Linkages',
// ];



const SERVICES = [
    1 => "HIV Test",
    2 => "STI Services",
    3 => "Pre-Exposure Prophylaxis (PrEP)",
    4 => "PEP",
    5 => "Counselling on Mental Health",
    6 => "Referral to TI services",
    7 => "ART Linkages"
];

const SERVICES_DESCRIPTION = [
    1 => "surveyAppointment.1",
    2 => "surveyAppointment.2",
    3 => "surveyAppointment.3",
    4 => "surveyAppointment.4",
    5 => "surveyAppointment.5",
    6 => "surveyAppointment.6",
    7 => "surveyAppointment.7",
];
// const SERVICES_DESCRIPTION = [
//     1 => "An HIV test is a medical procedure to detect the presence of the human immunodeficiency virus in a person's bloodstream.",
//     2 => "STI services refer to healthcare offerings related to the prevention, diagnosis, and treatment of sexually transmitted infections.",
//     3 => "Pre-Exposure Prophylaxis is a medication taken by individuals at high risk of HIV infection to reduce the likelihood of contracting the HIV virus. This should be taken under Doctors supervision only.",
//     4 => "PEP",
//     5 => "Counselling is a therapeutic process where a counsellor provides guidance and support to help individuals address emotional issues and common concerns such as Depression, Anxiety etc. In HIV related counseling, the counselor provides information regarding the HIV transmission/prevention, assesses the risk of the client and offers risk reduction counseling to the clients.",
//     6 => "Referral to TI and CBO/NGO Services involves directing individuals to services provided by Targeted Interventions (TI) and Community-Based Organisations (CBO) or Non-Governmental Organisations (NGO) for additional support in addressing health and social needs.",
//     7 => "Art linkage is the process of connecting individuals who test positive for HIV to Antiretroviral Therapy (ART) for the management of the virus and related health services."
// ];

const IS_ACTIVE = 'is_active';
const IS_DELETED = 'is_deleted';
const ACTIVE = true;
