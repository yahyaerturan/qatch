<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_users extends CI_Migration {

  public function up()
  {
    /**
     * v_user
     */
    $this->dbforge->add_field(array(
      'id_user'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'first_name'=>array('type'=>'VARCHAR','constraint'=>100),
      'last_name'=>array('type'=>'VARCHAR','constraint'=>100),
      'username'=>array('type'=>'VARCHAR','constraint'=>24),
      'password'=>array('type'=>'VARCHAR','constraint'=>200),
      'salt'=>array('type'=>'VARCHAR','constraint'=>200),
      'sex'=>array('type'=>'CHAR','constraint'=>1,'default'=>'U'),
      'birthday'=>array('type'=>'DATE','null'=>TRUE),
      'tcno'=>array('type'=>'VARCHAR','constraint'=>11,'null'=>TRUE),
      'tax_reg_office'=>array('type'=>'VARCHAR','constraint'=>32,'null'=>TRUE),
      'created_at'=>array('type'=>'DATETIME','null'=>TRUE),
      'verified_at'=>array('type'=>'DATETIME','null'=>TRUE),
      'last_login'=>array('type'=>'DATETIME','null'=>TRUE),
      'reset_at'=>array('type'=>'DATETIME','null'=>TRUE),
      'deleted_at'=>array('type'=>'DATETIME','null'=>TRUE),
      'suspended_at'=>array('type'=>'DATETIME','null'=>TRUE)
    ));
    $this->dbforge->add_key('id_user',TRUE); // True makes it PRIMARY
    $this->dbforge->add_key('username');
    $this->dbforge->create_table('v_user');
    $created_at = date('Y-m-d H:i:s');
    $data = array(
      array('first_name'=>'Yahya','last_name'=>'Erturan','username'=>'yahyaerturan','password'=>vayes_hash('vayessapass'),'salt'=>vayes_hash($created_at),'birthday'=>'1982-01-26','created_at'=>$created_at),
      array('first_name'=>'Serdar','last_name'=>'Gürsoy','username'=>'vayes','password'=>vayes_hash('vayes'),'salt'=>vayes_hash($created_at),'birthday'=>'1985-03-15','created_at'=>$created_at),
    );
    /**
     * Hashed by vstart3_model::hash() using md5 while 'nxQ2aH0AZ7xRBnU6ZIM5EivdCI0f0GmR'
     * password : vayessapass => '47a4f4615b442d4b5385e21797433419'
     */
    $this->db->insert_batch('v_user',$data);

  // ------------------------------------------------------------------------

    /**
     * v_user_url
     */
    $this->dbforge->add_field(array(
      'id_user'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE),
      'url'=>array('type'=>'VARCHAR','constraint'=>100),
      'title'=>array('type'=>'VARCHAR','constraint'=>255),
      'active'=>array('type'=>'TINYINT','constraint'=>1,'unsigned'=>TRUE,'default'=>1)
    ));
    $this->dbforge->create_table('v_user_url');
    $this->db->query('ALTER TABLE v_user_url ADD PRIMARY KEY (id_user,url)');
    $data = array(
      array('id_user'=>'1','url'=>'vayes-web-yazilim'),
      array('id_user'=>'2','url'=>'vayes-web-tasarim')
    );
    $this->db->insert_batch('v_user_url',$data);

  // ------------------------------------------------------------------------

    /**
     * v_user_email
     */
    $this->dbforge->add_field(array(
      'id_email'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'email'=>array('type'=>'VARCHAR','constraint'=>200),
      'id_user'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'default'=>0),
      'auth_src'=>array('type'=>'VARCHAR','constraint'=>3,'default'=>'reg'),
      'def_email'=>array('type'=>'TINYINT','constraint'=>1,'unsigned'=>TRUE,'default'=>0),
      'validation_code'=>array('type'=>'VARCHAR','constraint'=>200,'null'=>TRUE),
      'reset_code'=>array('type'=>'VARCHAR','constraint'=>200,'null'=>TRUE),
      'created_at'=>array('type'=>'DATETIME','null'=>TRUE),
      'verified_at'=>array('type'=>'DATETIME','null'=>TRUE)
    ));
    $this->dbforge->add_key('id_email',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_user_email');
    $data = array(
      array('email'=>'serdar@vayes.net','id_user'=>'2','auth_src'=>'reg','def_email'=>'1','created_at'=>date('Y-m-d H:i:s'),'verified_at'=>date('Y-m-d H:i:s')),
      array('email'=>'root@yahyaerturan.com','id_user'=>'1','auth_src'=>'reg','def_email'=>'1','created_at'=>date('Y-m-d H:i:s'),'verified_at'=>date('Y-m-d H:i:s'))
    );
    $this->db->insert_batch('v_user_email',$data);

  // ------------------------------------------------------------------------

    /**
     * v_address_type
     */
    $this->dbforge->add_field(array(
      'id_address_type'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'slug'=>array('type'=>'VARCHAR','constraint'=>255),
      'title'=>array('type'=>'VARCHAR','constraint'=>255),
      'ordering'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE,'default'=>0),
      'active'=>array('type'=>'TINYINT','constraint'=>1,'unsigned'=>TRUE,'default'=>1)
    ));
    $this->dbforge->add_key('id_address_type',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_address_type');
    $data = array(
      array('slug'=>'home-address','title'=>'Ev Adresi','ordering'=>'1'),
      array('slug'=>'work-address','title'=>'İş Adresi','ordering'=>'2'),
      array('slug'=>'invoice-address','title'=>'Fatura Adresi','ordering'=>'3'),
      array('slug'=>'delivery-address','title'=>'Teslimat Adresi','ordering'=>'4'),
    );
    $this->db->insert_batch('v_address_type',$data);

  // ------------------------------------------------------------------------

    /**
     * v_address
     */
    $this->dbforge->add_field(array(
      'id_address'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'id_address_type'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE),
      'address'=>array('type'=>'VARCHAR','constraint'=>255,'null'=>TRUE),
      'district'=>array('type'=>'VARCHAR','constraint'=>255,'null'=>TRUE),
      'id_city'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE),
      'country'=>array('type'=>'CHAR','constraint'=>5,'null'=>TRUE,'default'=>'TR'),
      'postal_code'=>array('type'=>'VARCHAR','constraint'=>32,'null'=>TRUE),
      'def_address'=>array('type'=>'TINYINT','constraint'=>1,'unsigned'=>TRUE,'default'=>0),
      'last_used_address'=>array('type'=>'TINYINT','constraint'=>1,'unsigned'=>TRUE,'default'=>0)
    ));
    $this->dbforge->add_key('id_address',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_address');
    $data = array('id_address_type'=>'2','address'=>'A. Kahveci Mh. Çalışlar Cd. Midpoint Residence No.2 K.3 D.27','district'=>'Beylikdüzü','id_city'=>'34','country'=>'TR','postal_code'=>'34528','def_address'=>'1');
    $this->db->insert('v_address',$data);

  // ------------------------------------------------------------------------

    /**
     * v_user_address
     */
    $this->dbforge->add_field(array(
      'id_user'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE),
      'id_address'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE)
    ));
    $this->dbforge->add_key('id_user', TRUE);
    $this->dbforge->add_key('id_address', TRUE);
    $this->dbforge->create_table('v_user_address');
    $this->db->insert('v_user_address',array('id_user'=>1,'id_address'=>1));
    $this->db->insert('v_user_address',array('id_user'=>2,'id_address'=>1));

  // ------------------------------------------------------------------------

    /**
     * v_user_image
     */
    $this->dbforge->add_field(array(
      'id_image'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'id_user'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'null'=>FALSE),
      'img_usage'=>array('type'=>'VARCHAR','constraint'=>3,'null'=>FALSE),
      'img_path'=>array('type'=>'VARCHAR','constraint'=>500,'nıll'=>FALSE),
      'uploaded_at'=>array('type'=>'DATETIME','null'=> TRUE),
      'uploaded_by'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'default'=>0),
      'modified_at'=>array('type'=>'DATETIME','null'=>TRUE),
      'modified_by'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'default'=>0 )
    ));
    $this->dbforge->add_key('id_image',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_user_image');

  // ------------------------------------------------------------------------

    /**
     * v_user_permission
     */
    $this->dbforge->add_field(array(
      'id_user'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE),
      'permissions'=>array('type'=>'TEXT')
    ));
    $this->dbforge->add_key('id_user',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_user_permission');
    $data = array(
      array('id_user'=>1,'permissions'=>'{}'),
      array('id_user'=>2,'permissions'=>'{}')
    );
    $this->db->insert_batch('v_user_permission',$data);

  // ------------------------------------------------------------------------

    /**
     * v_company
     */
    $this->dbforge->add_field(array(
      'id_company'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'company_name'=>array('type'=>'VARCHAR','constraint'=>255,'null'=>FALSE),
      'tax_office'=>array('type'=>'VARCHAR','constraint'=>100,'null'=>TRUE),
      'tax_number'=>array('type'=>'VARCHAR','constraint'=>12,'null'=>TRUE),
      'created_at'=>array('type'=>'DATETIME','null'=> TRUE),
      'created_by'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'default'=>0),
      'modified_at'=>array('type'=>'DATETIME','null'=>TRUE),
      'modified_by'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'default'=>0 )
    ));
    $this->dbforge->add_key('id_company',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_company');
    $data = array('company_name'=>'Vayes Web Yazılım Ticaret ve Bilişim Hizmetleri','tax_office'=>'Büyükçekmece','tax_number'=>'44245241972','created_at'=>date('Y-m-d H:i:s'),'created_by'=>'1');
    $this->db->insert('v_company',$data);

  // ------------------------------------------------------------------------

    /**
     * v_user_company
     */
    $this->dbforge->add_field(array(
      'id_user'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE),
      'id_company'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE)
    ));
    $this->dbforge->create_table('v_user_company');
    $this->db->query('ALTER TABLE v_user_company ADD PRIMARY KEY (id_user,id_company)');
    $data = array(
      array('id_user'=>1,'id_company'=>1),
      array('id_user'=>2,'id_company'=>1)
    );
    $this->db->insert_batch('v_user_company',$data);

  // ------------------------------------------------------------------------

    /**
     * v_company_permission
     */
    $this->dbforge->add_field(array(
      'id_company'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE),
      'permissions'=>array('type'=>'TEXT')
    ));
    $this->dbforge->add_key('id_company',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_company_permission');
    $data = array('id_company'=>1,'permissions'=>'{}');
    $this->db->insert('v_company_permission',$data);


  // ------------------------------------------------------------------------

    /**
     * v_group
     */
    $this->dbforge->add_field(array(
      'id_group'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'slug'=>array('type'=>'VARCHAR','constraint'=>255),
      'level'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>FALSE),
      'ordering'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE,'default'=>0),
      'active'=>array('type'=>'TINYINT','constraint'=>1,'unsigned'=>TRUE,'default'=>1)
    ));
    $this->dbforge->add_key('id_group',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_group');
    $data = array(
      array('slug'=>'root','level'=>32000,'ordering'=>1),
      array('slug'=>'vayes-admins','level'=>20000,'ordering'=>2),
      array('slug'=>'super-admins','level'=>10000,'ordering'=>3),
      array('slug'=>'admins','level'=>5000,'ordering'=>4),
      array('slug'=>'editors','level'=>1000,'ordering'=>5),
      array('slug'=>'authors','level'=>500,'ordering'=>6),
      array('slug'=>'users','level'=>100,'ordering'=>7),
      array('slug'=>'pending','level'=>50,'ordering'=>8),
      array('slug'=>'guests','level'=>10,'ordering'=>9),
      array('slug'=>'banned','level'=>-10,'ordering'=>10),
      array('slug'=>'deactivated','level'=>-100,'ordering'=>11)
    );
    $this->db->insert_batch('v_group',$data);

  // ------------------------------------------------------------------------

    /**
     * v_group_permission
     */
    $this->dbforge->add_field(array(
      'id_group'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE),
      'permissions'=>array('type'=>'TEXT')
    ));
    $this->dbforge->add_key('id_group',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_group_permission');
    $data = array(
      array('id_group'=>1,'permissions'=>'{}'),
      array('id_group'=>2,'permissions'=>'{}'),
      array('id_group'=>3,'permissions'=>'{}'),
      array('id_group'=>4,'permissions'=>'{}'),
      array('id_group'=>5,'permissions'=>'{}'),
      array('id_group'=>6,'permissions'=>'{}'),
      array('id_group'=>7,'permissions'=>'{}'),
      array('id_group'=>8,'permissions'=>'{}'),
      array('id_group'=>9,'permissions'=>'{}'),
      array('id_group'=>10,'permissions'=>'{}'),
      array('id_group'=>11,'permissions'=>'{}')
    );
    $this->db->insert_batch('v_group_permission',$data);

  // ------------------------------------------------------------------------

    /**
     * v_user_group
     */
    $this->dbforge->add_field(array(
      'id_user'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE),
      'id_group'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE)
    ));
    $this->dbforge->create_table('v_user_group');
    $this->db->query('ALTER TABLE v_user_group ADD PRIMARY KEY (id_user,id_group)');
    $data = array(
      'id_user'=>'1','id_group'=>'1'
    );
    $this->db->insert('v_user_group',$data);

  // ------------------------------------------------------------------------

    /**
     * v_role
     */
    $this->dbforge->add_field(array(
      'id_role'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'slug'=>array('type'=>'VARCHAR','constraint'=>255),
      'level'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>FALSE),
      'ordering'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE,'default'=>0),
      'active'=>array('type'=>'TINYINT','constraint'=>1,'unsigned'=>TRUE,'default'=>1)
    ));
    $this->dbforge->add_key('id_role',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_role');
    $data = array(
      array('slug'=>'root','level'=>32000,'ordering'=>1),
      array('slug'=>'system-managers','level'=>20000,'ordering'=>2),
      array('slug'=>'company-managers','level'=>10000,'ordering'=>3),
      array('slug'=>'project-managers','level'=>9000,'ordering'=>4),
      array('slug'=>'department-managers','level'=>8000,'ordering'=>5),
      array('slug'=>'department-employees','level'=>7000,'ordering'=>6),
      array('slug'=>'branches','level'=>6000,'ordering'=>7),
      array('slug'=>'main-dealers','level'=>5000,'ordering'=>8),
      array('slug'=>'sub-dealers','level'=>4000,'ordering'=>9),
      array('slug'=>'agencies','level'=>3000,'ordering'=>10),
      array('slug'=>'freelancers','level'=>2000,'ordering'=>11),
      array('slug'=>'generic','level'=>1000,'ordering'=>12)
    );
    $this->db->insert_batch('v_role',$data);

  // ------------------------------------------------------------------------

    /**
     * v_user_role
     */
    $this->dbforge->add_field(array(
      'id_user'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE),
      'id_role'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE)
    ));
    $this->dbforge->create_table('v_user_role');
    $this->db->query('ALTER TABLE v_user_role ADD PRIMARY KEY (id_user,id_role)');
    $data = array(
      'id_user'=>'1','id_role'=>'1'
    );
    $this->db->insert('v_user_role',$data);

  // ------------------------------------------------------------------------

    /**
     * v_role_permission
     */
    $this->dbforge->add_field(array(
      'id_role'=>array('type'=>'SMALLINT','constraint'=>6,'unsigned'=>TRUE),
      'permissions'=>array('type'=>'TEXT')
    ));
    $this->dbforge->add_key('id_role',TRUE); // True makes it PRIMARY
    $this->dbforge->create_table('v_role_permission');
    $data = array(
      array('id_role'=>1,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>2,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>3,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>4,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>5,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>6,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>7,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>8,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>9,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>10,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>11,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}'),
      array('id_role'=>12,'permissions'=>'{"upl_picture_limit_per_request":"5","upl_document_limit_per_request":"3","upl_video_limit_per_request":"1","upl_picture_max_size":"2048","upl_document_max_size":"4096","upl_video_max_size":"8192","media_attach_picture_limit":"3","media_attach_document_limit":"1","media_attach_video_limit":"1"}')
    );
    $this->db->insert_batch('v_role_permission',$data);
  }

  public function down()
  {
    $this->dbforge->drop_table('v_user',TRUE);
    $this->dbforge->drop_table('v_user_url',TRUE);
    $this->dbforge->drop_table('v_user_email',TRUE);
    $this->dbforge->drop_table('v_address_type',TRUE);
    $this->dbforge->drop_table('v_address',TRUE);
    $this->dbforge->drop_table('v_user_address',TRUE);
    $this->dbforge->drop_table('v_user_image',TRUE);
    $this->dbforge->drop_table('v_user_permission',TRUE);
    $this->dbforge->drop_table('v_company',TRUE);
    $this->dbforge->drop_table('v_user_company',TRUE);
    $this->dbforge->drop_table('v_company_permission',TRUE);
    $this->dbforge->drop_table('v_group',TRUE);
    $this->dbforge->drop_table('v_user_group',TRUE);
    $this->dbforge->drop_table('v_group_permission',TRUE);
    $this->dbforge->drop_table('v_role',TRUE);
    $this->dbforge->drop_table('v_user_role',TRUE);
    $this->dbforge->drop_table('v_role_permission',TRUE);
  }
}
