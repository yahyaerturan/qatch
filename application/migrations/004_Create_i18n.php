<?php
class Migration_Create_i18n extends CI_Migration {

  public function up()
  {
    /**
     * lang
     */
    $fields = array(
      'lang'=>array('type'=>'VARCHAR','constraint'=>8),
      'name'=>array('type'=>'VARCHAR','constraint'=>40,'null'=>TRUE),
      'local_name'=>array('type'=>'VARCHAR','constraint'=>40,'null'=>TRUE),
      // Flag Class for CSS FLAGS ex. English => flag-icon-{gb}
      'flag'=>array('type'=>'VARCHAR','constraint'=>8,'null'=>TRUE),
      'online'=>array('type'=>'CHAR','constraint'=>1,'default'=>0),
      'def'=>array('type'=>'CHAR','constraint'=>1,'default'=>0),
      'ordering'=>array('type'=>'INT','constraint'=>11,'null'=>TRUE),
      'direction'=>array('type'=>'CHAR','constraint'=>1,'default'=>1)
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_key('lang',TRUE);
    $this->dbforge->create_table('lang');
    // Add Turkish Language
    $data = ['lang'=>'tr','name'=>'Turkish','local_name'=>'Türkçe','flag'=>'tr','online'=>'1','def'=>'1','ordering'=>'1'];
    $this->db->insert('lang',$data);
    // Add English Language
    $data = ['lang'=>'en','name'=>'English','local_name'=>'English','flag'=>'gb','online'=>'1','def'=>'0','ordering'=>'2'];
    $this->db->insert('lang',$data);


    /**
     * i18n_country
     */

    // Build json data for i18n_country
    $json = '[
      {"code":"VI","tr":"ABD Virgin Adalar\u0131","en":"U.S. Virgin Islands"},
      {"code":"AF","tr":"Afganistan","en":"Afghanistan"},
      {"code":"AX","tr":"Aland Adalar\u0131","en":"\u00c5land Islands"},
      {"code":"DE","tr":"Almanya","en":"Germany"},
      {"code":"US","tr":"Amerika Birle\u015fik Devletleri","en":"United States"},
      {"code":"UM","tr":"Amerika Birle\u015fik Devletleri K\u00fc\u00e7\u00fck D\u0131\u015f Adalar\u0131","en":"U.S. Minor Outlying Islands"},
      {"code":"AS","tr":"Amerikan Samoas\u0131","en":"American Samoa"},
      {"code":"AD","tr":"Andorra","en":"Andorra"},
      {"code":"AO","tr":"Angola","en":"Angola"},
      {"code":"AI","tr":"Anguilla","en":"Anguilla"},
      {"code":"AQ","tr":"Antarktika","en":"Antarctica"},
      {"code":"AG","tr":"Antigua ve Barbuda","en":"Antigua and Barbuda"},
      {"code":"AR","tr":"Arjantin","en":"Argentina"},
      {"code":"AL","tr":"Arnavutluk","en":"Albania"},
      {"code":"AW","tr":"Aruba","en":"Aruba"},
      {"code":"AU","tr":"Avustralya","en":"Australia"},
      {"code":"AT","tr":"Avusturya","en":"Austria"},
      {"code":"AZ","tr":"Azerbaycan","en":"Azerbaijan"},
      {"code":"BS","tr":"Bahamalar","en":"Bahamas"},
      {"code":"BH","tr":"Bahreyn","en":"Bahrain"},
      {"code":"BD","tr":"Banglade\u015f","en":"Bangladesh"},
      {"code":"BB","tr":"Barbados","en":"Barbados"},
      {"code":"EH","tr":"Bat\u0131 Sahara","en":"Western Sahara"},
      {"code":"BZ","tr":"Belize","en":"Belize"},
      {"code":"BE","tr":"Bel\u00e7ika","en":"Belgium"},
      {"code":"BJ","tr":"Benin","en":"Benin"},
      {"code":"BM","tr":"Bermuda","en":"Bermuda"},
      {"code":"BY","tr":"Beyaz Rusya","en":"Belarus"},
      {"code":"BT","tr":"Bhutan","en":"Bhutan"},
      {"code":"AE","tr":"Birle\u015fik Arap Emirlikleri","en":"United Arab Emirates"},
      {"code":"GB","tr":"Birle\u015fik Krall\u0131k","en":"United Kingdom"},
      {"code":"BO","tr":"Bolivya","en":"Bolivia"},
      {"code":"BA","tr":"Bosna Hersek","en":"Bosnia and Herzegovina"},
      {"code":"BW","tr":"Botsvana","en":"Botswana"},
      {"code":"BV","tr":"Bouvet Adas\u0131","en":"Bouvet Island"},
      {"code":"BR","tr":"Brezilya","en":"Brazil"},
      {"code":"BN","tr":"Brunei","en":"Brunei"},
      {"code":"BG","tr":"Bulgaristan","en":"Bulgaria"},
      {"code":"BF","tr":"Burkina Faso","en":"Burkina Faso"},
      {"code":"BI","tr":"Burundi","en":"Burundi"},
      {"code":"CV","tr":"Cape Verde","en":"Cape Verde"},
      {"code":"KY","tr":"Cayman Adalar\u0131","en":"Cayman Islands"},
      {"code":"GI","tr":"Cebelitar\u0131k","en":"Gibraltar"},
      {"code":"DZ","tr":"Cezayir","en":"Algeria"},
      {"code":"CX","tr":"Christmas Adas\u0131","en":"Christmas Island"},
      {"code":"DJ","tr":"Cibuti","en":"Djibouti"},
      {"code":"CC","tr":"Cocos Adalar\u0131","en":"Cocos [Keeling] Islands"},
      {"code":"CK","tr":"Cook Adalar\u0131","en":"Cook Islands"},
      {"code":"DK","tr":"Danimarka","en":"Denmark"},
      {"code":"DO","tr":"Dominik Cumhuriyeti","en":"Dominican Republic"},
      {"code":"DM","tr":"Dominika","en":"Dominica"},
      {"code":"TL","tr":"Do\u011fu Timor","en":"Timor-Leste"},
      {"code":"EC","tr":"Ekvador","en":"Ecuador"},
      {"code":"GQ","tr":"Ekvator Ginesi","en":"Equatorial Guinea"},
      {"code":"SV","tr":"El Salvador","en":"El Salvador"},
      {"code":"ID","tr":"Endonezya","en":"Indonesia"},
      {"code":"ER","tr":"Eritre","en":"Eritrea"},
      {"code":"AM","tr":"Ermenistan","en":"Armenia"},
      {"code":"EE","tr":"Estonya","en":"Estonia"},
      {"code":"ET","tr":"Etiyopya","en":"Ethiopia"},
      {"code":"FK","tr":"Falkland Adalar\u0131","en":"Falkland Islands"},
      {"code":"FO","tr":"Faroe Adalar\u0131","en":"Faroe Islands"},
      {"code":"MA","tr":"Fas","en":"Morocco"},
      {"code":"FJ","tr":"Fiji","en":"Fiji"},
      {"code":"CI","tr":"Fildi\u015fi Sahili","en":"C\u00f4te d\u2019Ivoire"},
      {"code":"PH","tr":"Filipinler","en":"Philippines"},
      {"code":"PS","tr":"Filistin B\u00f6lgesi","en":"Palestinian Territories"},
      {"code":"FI","tr":"Finlandiya","en":"Finland"},
      {"code":"FR","tr":"Fransa","en":"France"},
      {"code":"GF","tr":"Frans\u0131z Guyanas\u0131","en":"French Guiana"},
      {"code":"TF","tr":"Frans\u0131z G\u00fcney B\u00f6lgeleri","en":"French Southern Territories"},
      {"code":"PF","tr":"Frans\u0131z Polinezyas\u0131","en":"French Polynesia"},
      {"code":"GA","tr":"Gabon","en":"Gabon"},
      {"code":"GM","tr":"Gambiya","en":"Gambia"},
      {"code":"GH","tr":"Gana","en":"Ghana"},
      {"code":"GN","tr":"Gine","en":"Guinea"},
      {"code":"GW","tr":"Gine-Bissau","en":"Guinea-Bissau"},
      {"code":"GD","tr":"Grenada","en":"Grenada"},
      {"code":"GL","tr":"Gr\u00f6nland","en":"Greenland"},
      {"code":"GP","tr":"Guadeloupe","en":"Guadeloupe"},
      {"code":"GU","tr":"Guam","en":"Guam"},
      {"code":"GT","tr":"Guatemala","en":"Guatemala"},
      {"code":"GG","tr":"Guernsey","en":"Guernsey"},
      {"code":"GY","tr":"Guyana","en":"Guyana"},
      {"code":"ZA","tr":"G\u00fcney Afrika","en":"South Africa"},
      {"code":"GS","tr":"G\u00fcney Georgia ve G\u00fcney Sandwich Adalar\u0131","en":"South Georgia and the South Sandwich Islands"},
      {"code":"KR","tr":"G\u00fcney Kore","en":"South Korea"},
      {"code":"CY","tr":"G\u00fcney K\u0131br\u0131s Rum Kesimi","en":"Cyprus"},
      {"code":"GE","tr":"G\u00fcrcistan","en":"Georgia"},
      {"code":"HT","tr":"Haiti","en":"Haiti"},
      {"code":"HM","tr":"Heard Adas\u0131 ve McDonald Adalar\u0131","en":"Heard Island and McDonald Islands"},
      {"code":"IN","tr":"Hindistan","en":"India"},
      {"code":"IO","tr":"Hint Okyanusu \u0130ngiliz B\u00f6lgesi","en":"British Indian Ocean Territory"},
      {"code":"NL","tr":"Hollanda","en":"Netherlands"},
      {"code":"AN","tr":"Hollanda Antilleri","en":"Netherlands Antilles"},
      {"code":"HN","tr":"Honduras","en":"Honduras"},
      {"code":"HK","tr":"Hong Kong SAR - \u00c7in","en":"Hong Kong SAR China"},
      {"code":"HR","tr":"H\u0131rvatistan","en":"Croatia"},
      {"code":"IQ","tr":"Irak","en":"Iraq"},
      {"code":"JM","tr":"Jamaika","en":"Jamaica"},
      {"code":"JP","tr":"Japonya","en":"Japan"},
      {"code":"JE","tr":"Jersey","en":"Jersey"},
      {"code":"KH","tr":"Kambo\u00e7ya","en":"Cambodia"},
      {"code":"CM","tr":"Kamerun","en":"Cameroon"},
      {"code":"CA","tr":"Kanada","en":"Canada"},
      {"code":"ME","tr":"Karada\u011f","en":"Montenegro"},
      {"code":"QA","tr":"Katar","en":"Qatar"},
      {"code":"KZ","tr":"Kazakistan","en":"Kazakhstan"},
      {"code":"KE","tr":"Kenya","en":"Kenya"},
      {"code":"KI","tr":"Kiribati","en":"Kiribati"},
      {"code":"CO","tr":"Kolombiya","en":"Colombia"},
      {"code":"KM","tr":"Komorlar","en":"Comoros"},
      {"code":"CG","tr":"Kongo - Brazavil","en":"Congo - Brazzaville"},
      {"code":"CD","tr":"Kongo - Kin\u015fasa","en":"Congo - Kinshasa"},
      {"code":"CR","tr":"Kosta Rika","en":"Costa Rica"},
      {"code":"KW","tr":"Kuveyt","en":"Kuwait"},
      {"code":"KP","tr":"Kuzey Kore","en":"North Korea"},
      {"code":"MP","tr":"Kuzey Mariana Adalar\u0131","en":"Northern Mariana Islands"},
      {"code":"CU","tr":"K\u00fcba","en":"Cuba"},
      {"code":"KG","tr":"K\u0131rg\u0131zistan","en":"Kyrgyzstan"},
      {"code":"LA","tr":"Laos","en":"Laos"},
      {"code":"LS","tr":"Lesotho","en":"Lesotho"},
      {"code":"LV","tr":"Letonya","en":"Latvia"},
      {"code":"LR","tr":"Liberya","en":"Liberia"},
      {"code":"LY","tr":"Libya","en":"Libya"},
      {"code":"LI","tr":"Liechtenstein","en":"Liechtenstein"},
      {"code":"LT","tr":"Litvanya","en":"Lithuania"},
      {"code":"LB","tr":"L\u00fcbnan","en":"Lebanon"},
      {"code":"LU","tr":"L\u00fcksemburg","en":"Luxembourg"},
      {"code":"HU","tr":"Macaristan","en":"Hungary"},
      {"code":"MG","tr":"Madagaskar","en":"Madagascar"},
      {"code":"MO","tr":"Makao S.A.R. \u00c7in","en":"Macau SAR China"},
      {"code":"MK","tr":"Makedonya","en":"Macedonia"},
      {"code":"MW","tr":"Malavi","en":"Malawi"},
      {"code":"MV","tr":"Maldivler","en":"Maldives"},
      {"code":"MY","tr":"Malezya","en":"Malaysia"},
      {"code":"ML","tr":"Mali","en":"Mali"},
      {"code":"MT","tr":"Malta","en":"Malta"},
      {"code":"IM","tr":"Man Adas\u0131","en":"Isle of Man"},
      {"code":"MH","tr":"Marshall Adalar\u0131","en":"Marshall Islands"},
      {"code":"MQ","tr":"Martinik","en":"Martinique"},
      {"code":"MU","tr":"Mauritius","en":"Mauritius"},
      {"code":"YT","tr":"Mayotte","en":"Mayotte"},
      {"code":"MX","tr":"Meksika","en":"Mexico"},
      {"code":"FM","tr":"Mikronezya Federal Eyaletleri","en":"Micronesia"},
      {"code":"MD","tr":"Moldova","en":"Moldova"},
      {"code":"MC","tr":"Monako","en":"Monaco"},
      {"code":"MS","tr":"Montserrat","en":"Montserrat"},
      {"code":"MR","tr":"Moritanya","en":"Mauritania"},
      {"code":"MZ","tr":"Mozambik","en":"Mozambique"},
      {"code":"MN","tr":"Mo\u011folistan","en":"Mongolia"},
      {"code":"MM","tr":"Myanmar","en":"Myanmar [Burma]"},
      {"code":"EG","tr":"M\u0131s\u0131r","en":"Egypt"},
      {"code":"NA","tr":"Namibya","en":"Namibia"},
      {"code":"NR","tr":"Nauru","en":"Nauru"},
      {"code":"NP","tr":"Nepal","en":"Nepal"},
      {"code":"NE","tr":"Nijer","en":"Niger"},
      {"code":"NG","tr":"Nijerya","en":"Nigeria"},
      {"code":"NI","tr":"Nikaragua","en":"Nicaragua"},
      {"code":"NU","tr":"Niue","en":"Niue"},
      {"code":"NF","tr":"Norfolk Adas\u0131","en":"Norfolk Island"},
      {"code":"NO","tr":"Norve\u00e7","en":"Norway"},
      {"code":"CF","tr":"Orta Afrika Cumhuriyeti","en":"Central African Republic"},
      {"code":"PK","tr":"Pakistan","en":"Pakistan"},
      {"code":"PW","tr":"Palau","en":"Palau"},
      {"code":"PA","tr":"Panama","en":"Panama"},
      {"code":"PG","tr":"Papua Yeni Gine","en":"Papua New Guinea"},
      {"code":"PY","tr":"Paraguay","en":"Paraguay"},
      {"code":"PE","tr":"Peru","en":"Peru"},
      {"code":"PN","tr":"Pitcairn","en":"Pitcairn Islands"},
      {"code":"PL","tr":"Polonya","en":"Poland"},
      {"code":"PT","tr":"Portekiz","en":"Portugal"},
      {"code":"PR","tr":"Porto Riko","en":"Puerto Rico"},
      {"code":"RE","tr":"Reunion","en":"R\u00e9union"},
      {"code":"RO","tr":"Romanya","en":"Romania"},
      {"code":"RW","tr":"Ruanda","en":"Rwanda"},
      {"code":"RU","tr":"Rusya Federasyonu","en":"Russia"},
      {"code":"BL","tr":"Saint Barthelemy","en":"Saint Barth\u00e9lemy"},
      {"code":"SH","tr":"Saint Helena","en":"Saint Helena"},
      {"code":"KN","tr":"Saint Kitts ve Nevis","en":"Saint Kitts and Nevis"},
      {"code":"LC","tr":"Saint Lucia","en":"Saint Lucia"},
      {"code":"MF","tr":"Saint Martin","en":"Saint Martin"},
      {"code":"PM","tr":"Saint Pierre ve Miquelon","en":"Saint Pierre and Miquelon"},
      {"code":"VC","tr":"Saint Vincent ve Grenadinler","en":"Saint Vincent and the Grenadines"},
      {"code":"WS","tr":"Samoa","en":"Samoa"},
      {"code":"SM","tr":"San Marino","en":"San Marino"},
      {"code":"ST","tr":"Sao Tome ve Principe","en":"S\u00e3o Tom\u00e9 and Pr\u00edncipe"},
      {"code":"SN","tr":"Senegal","en":"Senegal"},
      {"code":"SC","tr":"Sey\u015fel Adalar\u0131","en":"Seychelles"},
      {"code":"SL","tr":"Sierra Leone","en":"Sierra Leone"},
      {"code":"SG","tr":"Singapur","en":"Singapore"},
      {"code":"SK","tr":"Slovakya","en":"Slovakia"},
      {"code":"SI","tr":"Slovenya","en":"Slovenia"},
      {"code":"SB","tr":"Solomon Adalar\u0131","en":"Solomon Islands"},
      {"code":"SO","tr":"Somali","en":"Somalia"},
      {"code":"LK","tr":"Sri Lanka","en":"Sri Lanka"},
      {"code":"SD","tr":"Sudan","en":"Sudan"},
      {"code":"SR","tr":"Surinam","en":"Suriname"},
      {"code":"SY","tr":"Suriye","en":"Syria"},
      {"code":"SA","tr":"Suudi Arabistan","en":"Saudi Arabia"},
      {"code":"SJ","tr":"Svalbard ve Jan Mayen","en":"Svalbard and Jan Mayen"},
      {"code":"SZ","tr":"Svaziland","en":"Swaziland"},
      {"code":"RS","tr":"S\u0131rbistan","en":"Serbia"},
      {"code":"CS","tr":"S\u0131rbistan-Karada\u011f","en":"Serbia and Montenegro"},
      {"code":"TJ","tr":"Tacikistan","en":"Tajikistan"},
      {"code":"TZ","tr":"Tanzanya","en":"Tanzania"},
      {"code":"TH","tr":"Tayland","en":"Thailand"},
      {"code":"TW","tr":"Tayvan","en":"Taiwan"},
      {"code":"TG","tr":"Togo","en":"Togo"},
      {"code":"TK","tr":"Tokelau","en":"Tokelau"},
      {"code":"TO","tr":"Tonga","en":"Tonga"},
      {"code":"TT","tr":"Trinidad ve Tobago","en":"Trinidad and Tobago"},
      {"code":"TN","tr":"Tunus","en":"Tunisia"},
      {"code":"TC","tr":"Turks ve Caicos Adalar\u0131","en":"Turks and Caicos Islands"},
      {"code":"TV","tr":"Tuvalu","en":"Tuvalu"},
      {"code":"TR","tr":"T\u00fcrkiye","en":"Turkey"},
      {"code":"TM","tr":"T\u00fcrkmenistan","en":"Turkmenistan"},
      {"code":"UG","tr":"Uganda","en":"Uganda"},
      {"code":"UA","tr":"Ukrayna","en":"Ukraine"},
      {"code":"OM","tr":"Umman","en":"Oman"},
      {"code":"UY","tr":"Uruguay","en":"Uruguay"},
      {"code":"VU","tr":"Vanuatu","en":"Vanuatu"},
      {"code":"VA","tr":"Vatikan","en":"Vatican City"},
      {"code":"VE","tr":"Venezuela","en":"Venezuela"},
      {"code":"VN","tr":"Vietnam","en":"Vietnam"},
      {"code":"WF","tr":"Wallis ve Futuna","en":"Wallis and Futuna"},
      {"code":"YE","tr":"Yemen","en":"Yemen"},
      {"code":"NC","tr":"Yeni Kaledonya","en":"New Caledonia"},
      {"code":"NZ","tr":"Yeni Zelanda","en":"New Zealand"},
      {"code":"GR","tr":"Yunanistan","en":"Greece"},
      {"code":"ZM","tr":"Zambiya","en":"Zambia"},
      {"code":"ZW","tr":"Zimbabve","en":"Zimbabwe"},
      {"code":"TD","tr":"\u00c7ad","en":"Chad"},
      {"code":"CZ","tr":"\u00c7ek Cumhuriyeti","en":"Czech Republic"},
      {"code":"CN","tr":"\u00c7in","en":"China"},
      {"code":"UZ","tr":"\u00d6zbekistan","en":"Uzbekistan"},
      {"code":"JO","tr":"\u00dcrd\u00fcn","en":"Jordan"},
      {"code":"VG","tr":"\u0130ngiliz Virgin Adalar\u0131","en":"British Virgin Islands"},
      {"code":"IR","tr":"\u0130ran","en":"Iran"},
      {"code":"IE","tr":"\u0130rlanda","en":"Ireland"},
      {"code":"ES","tr":"\u0130spanya","en":"Spain"},
      {"code":"IL","tr":"\u0130srail","en":"Israel"},
      {"code":"SE","tr":"\u0130sve\u00e7","en":"Sweden"},
      {"code":"CH","tr":"\u0130svi\u00e7re","en":"Switzerland"},
      {"code":"IT","tr":"\u0130talya","en":"Italy"},
      {"code":"IS","tr":"\u0130zlanda","en":"Iceland"},
      {"code":"CL","tr":"\u015eili","en":"Chile"}
    ]';

    // Create table for i18n_country
    $fields = array(
      'code' => array('type'=>'VARCHAR','constraint'=>2,'null'=>FALSE),
      'tr' => array('type'=>'VARCHAR','constraint'=>255,'null'=>FALSE),
      'en' => array('type'=>'VARCHAR','constraint'=>255,'null'=>FALSE),
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_key('code',TRUE);
    $this->dbforge->create_table('i18n_country',TRUE);

    // Insert data for i18n_country
    // The second parameter of json_decode forces parsing into an associative array
    $data = json_decode($json, true);
    $this->db->insert_batch('i18n_country',$data);

    /**
     * i18n_city
     */

    // Build json data for i18n_city
    $json = '[
      {"id_city":"1","city_name":"Adana","dial_code":"322","plate_code":"1","country":"TR"},
      {"id_city":"2","city_name":"Ad\u0131yaman","dial_code":"416","plate_code":"2","country":"TR"},
      {"id_city":"3","city_name":"Afyonkarahisar","dial_code":"272","plate_code":"3","country":"TR"},
      {"id_city":"4","city_name":"A\u011fr\u0131","dial_code":"472","plate_code":"4","country":"TR"},
      {"id_city":"5","city_name":"Amasya","dial_code":"358","plate_code":"5","country":"TR"},
      {"id_city":"6","city_name":"Ankara","dial_code":"312","plate_code":"6","country":"TR"},
      {"id_city":"7","city_name":"Antalya","dial_code":"242","plate_code":"7","country":"TR"},
      {"id_city":"8","city_name":"Artvin","dial_code":"466","plate_code":"8","country":"TR"},
      {"id_city":"9","city_name":"Ayd\u0131n","dial_code":"256","plate_code":"9","country":"TR"},
      {"id_city":"10","city_name":"Bal\u0131kesir","dial_code":"266","plate_code":"10","country":"TR"},
      {"id_city":"11","city_name":"Bilecik","dial_code":"228","plate_code":"11","country":"TR"},
      {"id_city":"12","city_name":"Bing\u00f6l","dial_code":"426","plate_code":"12","country":"TR"},
      {"id_city":"13","city_name":"Bitlis","dial_code":"434","plate_code":"13","country":"TR"},
      {"id_city":"14","city_name":"Bolu","dial_code":"374","plate_code":"14","country":"TR"},
      {"id_city":"15","city_name":"Burdur","dial_code":"248","plate_code":"15","country":"TR"},
      {"id_city":"16","city_name":"Bursa","dial_code":"224","plate_code":"16","country":"TR"},
      {"id_city":"17","city_name":"\u00c7anakkale","dial_code":"286","plate_code":"17","country":"TR"},
      {"id_city":"18","city_name":"\u00c7ank\u0131r\u0131","dial_code":"376","plate_code":"18","country":"TR"},
      {"id_city":"19","city_name":"\u00c7orum","dial_code":"364","plate_code":"19","country":"TR"},
      {"id_city":"20","city_name":"Denizli","dial_code":"258","plate_code":"20","country":"TR"},
      {"id_city":"21","city_name":"Diyarbak\u0131r","dial_code":"412","plate_code":"21","country":"TR"},
      {"id_city":"22","city_name":"Edirne","dial_code":"284","plate_code":"22","country":"TR"},
      {"id_city":"23","city_name":"Elaz\u0131\u011f","dial_code":"424","plate_code":"23","country":"TR"},
      {"id_city":"24","city_name":"Erzincan","dial_code":"446","plate_code":"24","country":"TR"},
      {"id_city":"25","city_name":"Erzurum","dial_code":"442","plate_code":"25","country":"TR"},
      {"id_city":"26","city_name":"Eski\u015fehir","dial_code":"222","plate_code":"26","country":"TR"},
      {"id_city":"27","city_name":"Gaziantep","dial_code":"342","plate_code":"27","country":"TR"},
      {"id_city":"28","city_name":"Giresun","dial_code":"454","plate_code":"28","country":"TR"},
      {"id_city":"29","city_name":"G\u00fcm\u00fc\u015fhane","dial_code":"456","plate_code":"29","country":"TR"},
      {"id_city":"30","city_name":"Hakkari","dial_code":"438","plate_code":"30","country":"TR"},
      {"id_city":"31","city_name":"Hatay","dial_code":"326","plate_code":"31","country":"TR"},
      {"id_city":"32","city_name":"Isparta","dial_code":"246","plate_code":"32","country":"TR"},
      {"id_city":"33","city_name":"Mersin(\u0130\u00e7el)","dial_code":"324","plate_code":"33","country":"TR"},
      {"id_city":"34","city_name":"\u0130stanbul","dial_code":"212|216","plate_code":"34","country":"TR"},
      {"id_city":"35","city_name":"\u0130zmir","dial_code":"232","plate_code":"35","country":"TR"},
      {"id_city":"36","city_name":"Kars","dial_code":"474","plate_code":"36","country":"TR"},
      {"id_city":"37","city_name":"Kastamonu","dial_code":"366","plate_code":"37","country":"TR"},
      {"id_city":"38","city_name":"Kayseri","dial_code":"352","plate_code":"38","country":"TR"},
      {"id_city":"39","city_name":"K\u0131rklareli","dial_code":"318","plate_code":"39","country":"TR"},
      {"id_city":"40","city_name":"K\u0131r\u015fehir","dial_code":"386","plate_code":"40","country":"TR"},
      {"id_city":"41","city_name":"Kocaeli","dial_code":"262","plate_code":"41","country":"TR"},
      {"id_city":"42","city_name":"Kahramanmara\u015f","dial_code":"332","plate_code":"42","country":"TR"},
      {"id_city":"43","city_name":"Konya","dial_code":"274","plate_code":"43","country":"TR"},
      {"id_city":"44","city_name":"K\u00fctahya","dial_code":"422","plate_code":"44","country":"TR"},
      {"id_city":"45","city_name":"Malatya","dial_code":"236","plate_code":"45","country":"TR"},
      {"id_city":"46","city_name":"Manisa","dial_code":"344","plate_code":"46","country":"TR"},
      {"id_city":"47","city_name":"Mardin","dial_code":"482","plate_code":"47","country":"TR"},
      {"id_city":"48","city_name":"Mu\u011fla","dial_code":"252","plate_code":"48","country":"TR"},
      {"id_city":"49","city_name":"Mu\u015f","dial_code":"436","plate_code":"49","country":"TR"},
      {"id_city":"50","city_name":"Nev\u015fehir","dial_code":"384","plate_code":"50","country":"TR"},
      {"id_city":"51","city_name":"Ni\u011fde","dial_code":"388","plate_code":"51","country":"TR"},
      {"id_city":"52","city_name":"Ordu","dial_code":"452","plate_code":"52","country":"TR"},
      {"id_city":"53","city_name":"Rize","dial_code":"464","plate_code":"53","country":"TR"},
      {"id_city":"54","city_name":"Sakarya","dial_code":"264","plate_code":"54","country":"TR"},
      {"id_city":"55","city_name":"Samsun","dial_code":"362","plate_code":"55","country":"TR"},
      {"id_city":"56","city_name":"Siirt","dial_code":"484","plate_code":"56","country":"TR"},
      {"id_city":"57","city_name":"Sinop","dial_code":"368","plate_code":"57","country":"TR"},
      {"id_city":"58","city_name":"Sivas","dial_code":"346","plate_code":"58","country":"TR"},
      {"id_city":"59","city_name":"Tekirda\u011f","dial_code":"282","plate_code":"59","country":"TR"},
      {"id_city":"60","city_name":"Tokat","dial_code":"356","plate_code":"60","country":"TR"},
      {"id_city":"61","city_name":"Trabzon","dial_code":"462","plate_code":"61","country":"TR"},
      {"id_city":"62","city_name":"Tunceli","dial_code":"428","plate_code":"62","country":"TR"},
      {"id_city":"63","city_name":"\u015eanl\u0131urfa","dial_code":"414","plate_code":"63","country":"TR"},
      {"id_city":"64","city_name":"U\u015fak","dial_code":"276","plate_code":"64","country":"TR"},
      {"id_city":"65","city_name":"Van","dial_code":"432","plate_code":"65","country":"TR"},
      {"id_city":"66","city_name":"Yozgat","dial_code":"354","plate_code":"66","country":"TR"},
      {"id_city":"67","city_name":"Zonguldak","dial_code":"372","plate_code":"67","country":"TR"},
      {"id_city":"68","city_name":"Aksaray","dial_code":"382","plate_code":"68","country":"TR"},
      {"id_city":"69","city_name":"Bayburt","dial_code":"458","plate_code":"69","country":"TR"},
      {"id_city":"70","city_name":"Karaman","dial_code":"338","plate_code":"70","country":"TR"},
      {"id_city":"71","city_name":"K\u0131r\u0131kkale","dial_code":"318","plate_code":"71","country":"TR"},
      {"id_city":"72","city_name":"Batman","dial_code":"488","plate_code":"72","country":"TR"},
      {"id_city":"73","city_name":"\u015e\u0131rnak","dial_code":"486","plate_code":"73","country":"TR"},
      {"id_city":"74","city_name":"Bart\u0131n","dial_code":"378","plate_code":"74","country":"TR"},
      {"id_city":"75","city_name":"Ardahan","dial_code":"478","plate_code":"75","country":"TR"},
      {"id_city":"76","city_name":"I\u011fd\u0131r","dial_code":"476","plate_code":"76","country":"TR"},
      {"id_city":"77","city_name":"Yalova","dial_code":"226","plate_code":"77","country":"TR"},
      {"id_city":"78","city_name":"Karab\u00fck","dial_code":"370","plate_code":"78","country":"TR"},
      {"id_city":"79","city_name":"Kilis","dial_code":"348","plate_code":"79","country":"TR"},
      {"id_city":"80","city_name":"Osmaniye","dial_code":"328","plate_code":"80","country":"TR"},
      {"id_city":"81","city_name":"D\u00fczce","dial_code":"380","plate_code":"81","country":"TR"}
    ]';

    // Create table for i18n_city
    $fields = array(
      'id_city' => array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'null'=>FALSE,'auto_increment'=>TRUE),
      'city_name' => array('type'=>'VARCHAR','constraint'=>255,'null'=>FALSE),
      'dial_code' => array('type'=>'VARCHAR','constraint'=>10,'null'=>TRUE),
      'plate_code' => array('type'=>'VARCHAR','constraint'=>10,'null'=>TRUE),
      'country' => array('type'=>'VARCHAR','constraint'=>2,'null'=>FALSE)
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_key('id_city',TRUE);
    $this->dbforge->add_key('country');
    $this->dbforge->create_table('i18n_city',TRUE);

    // Insert data for i18n_city
    $data = json_decode($json, true);
    $this->db->insert_batch('i18n_city',$data);


    /**
     * i18n_static
     */

    // Build json data for i18n_static
    $json = '[
      {"lang":"tr","lang_index":"home","index_title":"Anasayfa","translation":"Anasayfa"},
      {"lang":"tr","lang_index":"about_us","index_title":"Anasayfa Hakkımızda Blok Başlığı","translation":"Hakkımızda"},
      {"lang":"tr","lang_index":"products","index_title":"Anasayfa Ürünler Blok Başlığı","translation":"Ürünler"},
      {"lang":"tr","lang_index":"read_more","index_title":"Devamını Oku Bağlantısı","translation":"Devamını Oku"},
      {"lang":"tr","lang_index":"send","index_title":"Gönder Düğmesi","translation":"Gönder"},
      {"lang":"tr","lang_index":"site_title","index_title":"Site Başlığı","translation":"vStart 3"},
      {"lang":"en","lang_index":"home","index_title":"Link to Home Page","translation":"Home"},
      {"lang":"en","lang_index":"about_us","index_title":"Block Heading to About Us in Home","translation":"About Us"},
      {"lang":"en","lang_index":"products","index_title":"Block Heading to Products in Home","translation":"Products"},
      {"lang":"en","lang_index":"read_more","index_title":"Read More Link Text","translation":"read more"},
      {"lang":"en","lang_index":"send","index_title":"Send Button Text","translation":"Send"},
      {"lang":"en","lang_index":"site_title","index_title":"Site Title","translation":"vStart 3"}
    ]';

    // Create table for i18n_static
    $fields = array(
      'lang' => array('type'=>'VARCHAR','constraint'=>5,'null'=>FALSE),
      'lang_index' => array('type'=>'VARCHAR','constraint'=>255,'null'=>FALSE),
      'index_title' => array('type'=>'VARCHAR','constraint'=>255,'null'=>TRUE),
      'translation' => array('type'=>'TEXT','null'=>TRUE),
      'link_to' => array('type'=>'VARCHAR','constraint'=>255,'null'=>TRUE)
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->create_table('i18n_static',TRUE);
    $this->db->query('ALTER TABLE i18n_static ADD PRIMARY KEY (lang,lang_index)');

    // Insert data for i18n_static
    $data = json_decode($json, true);
    $this->db->insert_batch('i18n_static',$data);
  }

  function down() {
    $this->dbforge->drop_table('lang',TRUE);
    $this->dbforge->drop_table('i18n_country',TRUE);
    $this->dbforge->drop_table('i18n_city',TRUE);
    $this->dbforge->drop_table('i18n_static',TRUE);
  }

}
