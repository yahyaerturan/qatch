<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_qatch extends CI_Migration {

  public function up()
  {
    /**
     * q_urls
     */
    $this->dbforge->add_field(array(
      'id_url'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'id_secured'=>array('type'=>'VARCHAR','constraint'=>18,'null'=>TRUE),
      'long_url'=>array('type'=>'VARCHAR','constraint'=>255),
      'created_at'=>array('type'=>'TIMESTAMP','null'=>TRUE),
      'updated_at'=>array('type'=>'TIMESTAMP','null'=>TRUE),
      'is_deleted'=>array('type'=>'TINYINT','constraint'=>1,'unsigned'=>TRUE,'default'=>0)
    ));
    $this->dbforge->add_key('id_url',TRUE); // True makes it PRIMARY
    $this->dbforge->add_key('id_secured');
    $this->dbforge->create_table('q_urls');

  // ------------------------------------------------------------------------

    /**
     * q_redirects
     */
    $this->dbforge->add_field(array(
      'id_redirect'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'id_url'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE),
      'total_hits'=>array('type'=>'BIGINT','constraint'=>18,'unsigned'=>TRUE,'default'=>0),
      'last_accessed_at'=>array('type'=>'VARCHAR','constraint'=>100,'null'=>TRUE),
      'last_accessed_ip'=>array('type'=>'TIMESTAMP','null'=>TRUE)
    ));
    $this->dbforge->add_key('id_redirect',TRUE); // True makes it PRIMARY
    $this->dbforge->add_key('id_url');
    $this->dbforge->create_table('q_redirects');

  // ------------------------------------------------------------------------

  }

  public function down()
  {
    $this->dbforge->drop_table('q_urls',TRUE);
    $this->dbforge->drop_table('q_redirects',TRUE);

  }
}
