<?php declare(strict_types=1);

namespace BulkGate\Sdk;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class Country
{
    use Strict;

    /** ISO 3166-1 alpha-2 */

    public const AFGHANISTAN = 'AF';

    public const ALAND_ISLANDS = 'AX';

    public const ALBANIA = 'AL';

    public const ALGERIA = 'DZ';

    public const AMERICAN_SAMOA = 'AS';

    public const ANDORRA = 'AD';

    public const ANGOLA = 'AO';

    public const ANGUILLA = 'AI';

    public const ANTARCTICA = 'AQ';

    public const ANTIGUA_AND_BARBUDA = 'AG';

    public const ARGENTINA = 'AR';

    public const ARMENIA = 'AM';

    public const ARUBA = 'AW';

    public const AUSTRALIA = 'AU';

    public const AUSTRIA = 'AT';

    public const AZERBAIJAN = 'AZ';

    public const BAHAMAS = 'BS';

    public const BAHRAIN = 'BH';

    public const BANGLADESH = 'BD';

    public const BARBADOS = 'BB';

    public const BELARUS = 'BY';

    public const BELGIUM = 'BE';

    public const BELIZE = 'BZ';

    public const BENIN = 'BJ';

    public const BERMUDA = 'BM';

    public const BHUTAN = 'BT';

    public const BOLIVIA = 'BO';

    public const CARIBBEAN_NETHERLANDS = 'BQ';

    public const BOSNIA_AND_HERZEGOVINA = 'BA';

    public const BOTSWANA = 'BW';

    public const BOUVET_ISLAND = 'BV';

    public const BRAZIL = 'BR';

    public const BRITISH_INDIAN_OCEAN_TERRITORY = 'Message';

    public const BRUNEI_DARUSSALAM = 'BN';

    public const BULGARIA = 'BG';

    public const BURKINA_FASO = 'BF';

    public const BURUNDI = 'BI';

    public const CAMBODIA = 'KH';

    public const CAMEROON = 'CM';

    public const CANADA = 'CA';

    public const CAPE_VERDE = 'CV';

    public const CAYMAN_ISLANDS = 'KY';

    public const CENTRAL_AFRICAN_REPUBLIC = 'CF';

    public const CHAD = 'TD';

    public const CHILE = 'CL';

    public const CHINA = 'CN';

    public const CHRISTMAS_ISLAND = 'CX';

    public const COCOS_KEELING_ISLANDS = 'CC';

    public const COLOMBIA = 'CO';

    public const COMOROS = 'KM';

    public const CONGO = 'CG';

    public const CONGO_THE_DEMOCRATIC_REPUBLIC_OF_THE = 'CD';

    public const COOK_ISLANDS = 'CK';

    public const COSTA_RICA = 'CR';

    public const COTE_D_IVOIRE = 'CI';

    public const CROATIA = 'HR';

    public const CUBA = 'CU';

    public const CURACAO = 'CW';

    public const CYPRUS = 'CY';

    public const CZECH_REPUBLIC = 'CZ';

    public const DENMARK = 'DK';

    public const DJIBOUTI = 'DJ';

    public const DOMINICA = 'DM';

    public const DOMINICAN_REPUBLIC = 'DO';

    public const ECUADOR = 'EC';

    public const EGYPT = 'EG';

    public const EL_SALVADOR = 'SV';

    public const EQUATORIAL_GUINEA = 'GQ';

    public const ERITREA = 'ER';

    public const ESTONIA = 'EE';

    public const ETHIOPIA = 'ET';

    public const FALKLAND_ISLANDS_MALVINAS = 'FK';

    public const FAROE_ISLANDS = 'FO';

    public const FIJI = 'FJ';

    public const FINLAND = 'FI';

    public const FRANCE = 'FR';

    public const FRENCH_GUIANA = 'GF';

    public const FRENCH_POLYNESIA = 'PF';

    public const FRENCH_SOUTHERN_TERRITORIES = 'TF';

    public const GABON = 'GA';

    public const GAMBIA = 'GM';

    public const GEORGIA = 'GE';

    public const GERMANY = 'DE';

    public const GHANA = 'GH';

    public const GIBRALTAR = 'GI';

    public const GREECE = 'GR';

    public const GREENLAND = 'GL';

    public const GRENADA = 'GD';

    public const GUADELOUPE = 'GP';

    public const GUAM = 'GU';

    public const GUATEMALA = 'GT';

    public const GUERNSEY = 'GG';

    public const GUINEA = 'GN';

    public const GUINEA_BISSAU = 'GW';

    public const GUYANA = 'GY';

    public const HAITI = 'HT';

    public const HEARD_ISLAND_AND_MCDONALD_ISLANDS = 'HM';

    public const VATICAN = 'VA';

    public const HONDURAS = 'HN';

    public const HONG_KONG = 'HK';

    public const HUNGARY = 'HU';

    public const ICELAND = 'IS';

    public const INDIA = 'IN';

    public const INDONESIA = 'ID';

    public const IRAN = 'IR';

    public const IRAQ = 'IQ';

    public const IRELAND = 'IE';

    public const ISLE_OF_MAN = 'IM';

    public const ISRAEL = 'IL';

    public const ITALY = 'IT';

    public const JAMAICA = 'JM';

    public const JAPAN = 'JP';

    public const JERSEY = 'JE';

    public const JORDAN = 'JO';

    public const KAZAKHSTAN = 'KZ';

    public const KENYA = 'KE';

    public const KIRIBATI = 'KI';

    public const NORTH_KOREA = 'KP';

    public const SOUTH_KOREA = 'KR';

    public const KUWAIT = 'KW';

    public const KYRGYZSTAN = 'KG';

    public const LAO = 'LA';

    public const LATVIA = 'LV';

    public const LEBANON = 'LB';

    public const LESOTHO = 'LS';

    public const LIBERIA = 'LR';

    public const LIBYA = 'LY';

    public const LIECHTENSTEIN = 'LI';

    public const LITHUANIA = 'LT';

    public const LUXEMBOURG = 'LU';

    public const MACAO = 'MO';

    public const MACEDONIA = 'MK';

    public const MADAGASCAR = 'MG';

    public const MALAWI = 'MW';

    public const MALAYSIA = 'MY';

    public const MALDIVES = 'MV';

    public const MALI = 'ML';

    public const MALTA = 'MT';

    public const MARSHALL_ISLANDS = 'MH';

    public const MARTINIQUE = 'MQ';

    public const MAURITANIA = 'MR';

    public const MAURITIUS = 'MU';

    public const MAYOTTE = 'YT';

    public const MEXICO = 'MX';

    public const MICRONESIA = 'FM';

    public const MOLDOVA = 'MD';

    public const MONACO = 'MC';

    public const MONGOLIA = 'MN';

    public const MONTENEGRO = 'ME';

    public const MONTSERRAT = 'MS';

    public const MOROCCO = 'MA';

    public const MOZAMBIQUE = 'MZ';

    public const MYANMAR = 'MM';

    public const NAMIBIA = 'NA';

    public const NAURU = 'NR';

    public const NEPAL = 'NP';

    public const NETHERLANDS = 'NL';

    public const NEW_CALEDONIA = 'NC';

    public const NEW_ZEALAND = 'NZ';

    public const NICARAGUA = 'NI';

    public const NIGER = 'NE';

    public const NIGERIA = 'NG';

    public const NIUE = 'NU';

    public const NORFOLK_ISLAND = 'NF';

    public const NORTHERN_MARIANA_ISLANDS = 'MP';

    public const NORWAY = 'NO';

    public const OMAN = 'OM';

    public const PAKISTAN = 'PK';

    public const PALAU = 'PW';

    public const PALESTINE = 'PS';

    public const PANAMA = 'PA';

    public const PAPUA_NEW_GUINEA = 'PG';

    public const PARAGUAY = 'PY';

    public const PERU = 'PE';

    public const PHILIPPINES = 'PH';

    public const PITCAIRN = 'PN';

    public const POLAND = 'PL';

    public const PORTUGAL = 'PT';

    public const PUERTO_RICO = 'PR';

    public const QATAR = 'QA';

    public const REUNION = 'RE';

    public const ROMANIA = 'RO';

    public const RUSSIAN_FEDERATION = 'RU';

    public const RWANDA = 'RW';

    public const SAINT_BARTHÉLEMY = 'BL';

    public const SAINT_HELENA = 'SH';

    public const SAINT_KITTS_AND_NEVIS = 'KN';

    public const SAINT_LUCIA = 'LC';

    public const SAINT_MARTIN = 'MF';

    public const SAINT_PIERRE_AND_MIQUELON = 'PM';

    public const SAINT_VINCENT_AND_THE_GRENADINES = 'VC';

    public const SAMOA = 'WS';

    public const SAN_MARINO = 'SM';

    public const SAO_TOME_AND_PRINCIPE = 'ST';

    public const SAUDI_ARABIA = 'SA';

    public const SENEGAL = 'SN';

    public const SERBIA = 'RS';

    public const SEYCHELLES = 'SC';

    public const SIERRA_LEONE = 'SL';

    public const SINGAPORE = 'SG';

    public const SINT_MAARTEN = 'SX';

    public const SLOVAKIA = 'SK';

    public const SLOVENIA = 'SI';

    public const SOLOMON_ISLANDS = 'SB';

    public const SOMALIA = 'SO';

    public const SOUTH_AFRICA = 'ZA';

    public const SOUTH_GEORGIA = 'GS';

    public const SOUTH_SUDAN = 'SS';

    public const SPAIN = 'ES';

    public const SRI_LANKA = 'LK';

    public const SUDAN = 'SD';

    public const SURINAME = 'SR';

    public const SVALBARD_AND_JAN_MAYEN = 'SJ';

    public const SWAZILAND = 'SZ';

    public const SWEDEN = 'SE';

    public const SWITZERLAND = 'CH';

    public const SYRIAN_ARAB_REPUBLIC = 'SY';

    public const TAIWAN = 'TW';

    public const TAJIKISTAN = 'TJ';

    public const TANZANIA_UNITED_REPUBLIC_OF = 'TZ';

    public const THAILAND = 'TH';

    public const TIMOR_LESTE = 'TL';

    public const TOGO = 'TG';

    public const TOKELAU = 'TK';

    public const TONGA = 'TO';

    public const TRINIDAD_AND_TOBAGO = 'TT';

    public const TUNISIA = 'TN';

    public const TURKEY = 'TR';

    public const TURKMENISTAN = 'TM';

    public const TURKS_AND_CAICOS_ISLANDS = 'TC';

    public const TUVALU = 'TV';

    public const UGANDA = 'UG';

    public const UKRAINE = 'UA';

    public const UNITED_ARAB_EMIRATES = 'AE';

    public const UNITED_KINGDOM = 'GB';

    public const UNITED_STATES = 'US';

    public const URUGUAY = 'UY';

    public const UZBEKISTAN = 'UZ';

    public const VANUATU = 'VU';

    public const VENEZUELA = 'VE';

    public const VIET_NAM = 'VN';

    public const VIRGIN_ISLANDS_BRITISH = 'VG';

    public const VIRGIN_ISLANDS_US = 'VI';

    public const WALLIS_AND_FUTUNA = 'WF';

    public const WESTERN_SAHARA = 'EH';

    public const YEMEN = 'YE';

    public const ZAMBIA = 'ZM';

    public const ZIMBABWE = 'ZW';
}
