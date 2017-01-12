<?php
class User {
    const P_USER_NAME             = 'booking_user';
    const P_USER_DISPLAY_NAME     = '会员';
    const P_USER_CAPABILITY       = 'booking_view';
    const P_USER_ADMIN_CAPABILITY = 'booking_all';
    public function __construct() {}
    /*
    $args = array(
    'blog_id'      => $GLOBALS['blog_id'],
    'role'         => '',
    'meta_key'     => '',
    'meta_value'   => '',
    'meta_compare' => '',
    'meta_query'   => array(),
    'include'      => array(),
    'exclude'      => array(),
    'orderby'      => 'login',
    'order'        => 'ASC',
    'offset'       => '',
    'search'       => '',
    'number'       => '',
    'count_total'  => false,
    'fields'       => 'all',
    'who'          => ''
    );
     */
    public function getUserList($page = 0, $count = 20) {
        $params = array(
            'role'   => self::P_USER_NAME,
            'offset' => $page * $count,
            'number' => $count
        );
        $args      = http_build_query($params);
        $user_list = get_users($args);
        $ret       = array();
        foreach ($user_list as $one) {
            $tmp         = $this->object2array($one);
            $tmp['meta'] = get_user_meta($tmp['ID']);
            $ret[]       = $tmp;
        }
        return $ret;
    }
    public function getUserInfo($userid) {
        $info         = $this->object2array(get_userdata($userid));
        $meta_info    = get_user_meta($userid);
        $info['meta'] = $meta_info;
        return $info;
    }
    public function getCurrentUserInfo() {
        return get_currentuserinfo();
    }
    public function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                if (is_object($value)) {
                    $array[$key] = $this->object2array($value);
                } else {
                    $array[$key] = $value;
                }
            }
        } else {
            $array = $object;
        }
        return $array;
    }
    public function pluginIni() {
        //$role = get_role( 'author' );
        //$role = get_role('administrator');
        //$role = get_role('booking_user');
        //$role = get_role('subscriber');
        // $role->remove_cap(  1 );
        $this->addRole();
        $this->addExtField();
        //权限验证 current_user_can( self::P_USER_CAPABILITY );
    }
    public function addRole() {
        $role           = get_role('subscriber');
        $capabilities   = $role->capabilities;
        $capabilities[] = self::P_USER_CAPABILITY;
        add_role(self::P_USER_NAME, self::P_USER_DISPLAY_NAME, $capabilities);
        //获取 "author" 的角色对象
        $role = get_role('administrator');
        //为角色对象添加权限
        $role->add_cap(self::P_USER_ADMIN_CAPABILITY);
    }
    public function addExtField() {
        add_action('show_user_profile', array($this, 'extra_user_profile_fields'));
        add_action('edit_user_profile', array($this, 'extra_user_profile_fields'));

        add_action('personal_options_update', array($this, 'save_extra_user_profile_fields'));
        add_action('edit_user_profile_update', array($this, 'save_extra_user_profile_fields'));
    }
    public function extra_user_profile_fields($user) {
        ?>
        <h3><?php _e("预约所需额外信息", "blank");?></h3>
        <table class="form-table">
            <tr>
                <th><label for="tel1"><?php _e("tel number");?></label></th>
                <td>
                    <input type="text" name="tel1" id="tel1" value="<?php echo esc_attr(get_the_author_meta('tel1', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("请输入您的电话号码");?></span>
                </td>
            </tr>
            <tr>
                <th><label for="tel2"><?php _e("tel2");?></label></th>
                <td>
                    <input type="text" name="tel2" id="tel2" value="<?php echo esc_attr(get_the_author_meta('tel2', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("请输入您的备用电话号");?></span>
                </td>
            </tr>
            <tr>
                <th><label for="address"><?php _e("address");?></label></th>
                <td>
                    <input type="text" name="address" id="address" value="<?php echo esc_attr(get_the_author_meta('address', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("请输入您的住址");?></span>
                </td>
            </tr>
            <tr>
                <th><label for="address_code"><?php _e("address_code");?></label></th>
                <td>
                    <input type="text" name="address_code" id="address_code" value="<?php echo esc_attr(get_the_author_meta('address_code', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("请输入您的邮编");?></span>
                </td>
            </tr>
            <tr>
                <th><label for="age"><?php _e("age");?></label></th>
                <td>
                    <input type="text" name="age" id="age" value="<?php echo esc_attr(get_the_author_meta('age', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("请输入您的年龄");?></span>
                </td>
            </tr>
        </table>
        <?php
}
    public function save_extra_user_profile_fields($user_id) {
        if ( ! current_user_can('edit_user', $user_id)) {
            return false;
        }
        update_usermeta($user_id, 'tel1', $_POST['tel1']);
        update_usermeta($user_id, 'tel2', $_POST['tel2']);
        update_usermeta($user_id, 'address', $_POST['address']);
        update_usermeta($user_id, 'address_code', $_POST['address_code']);
        update_usermeta($user_id, 'age', $_POST['age']);
    }
}
/*
WP_User类

这个类可以管理每个用户的角色和权限，这意味着可以为一个特定具体的用户分配多个角色，或者为当前用户添加特定的权限，不论他目前是什么角色。

首先需要获取用户对象来操纵它的角色和权限：

//通过用户ID得到用户对象
$user = new WP_User( $id );

//或者通过用户名
$user = new WP_User( null, $name );
我们可以通过用户ID或用户名得到一个用户对象。对于第二种方法，第一个参数必须是空的（null或空字符串），如：

//通过ID得到管理员对象
$admin = new WP_User( 1 );

//通过用户名得到管理员对象
$admin = new WP_User( null, 'admin' );
一旦得到了用户对象，就可以为这个用户的添加另一个角色，而无需修改他目前的角色，这意味着用户可以有多个角色：

$user->add_role( $role_name );
也可以使用 remove_role()，来为该用户删除某个角色：

$user->remove_role( $role_name );
还可以为该用户设置一个角色，这意味着该用户将被删除当前所有的角色，并分配一个新的角色：

$user->set_role( $role_name );
对于权限操作，也有很多的方法来做各种事情：

//检查该用户是否具有某种权限或角色名称
if ( $user->has_cap( $cap_name ) ) {
//做一些事
}

//为用户添加权限
$user->add_cap( $cap_name );

//为用户删除权限
$user->remove_cap( $cap_name );

//删除用户所有权限
$user->remove_all_caps();
 */
