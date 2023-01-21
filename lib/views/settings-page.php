<?php

if (!defined('ABSPATH')) exit();

?>

<div id="mla-plugin" class="wrap"> 
  <div id="icon-plugins" class="icon32"></div> 
  <h1><?php _e('Minimal Login Attempts', 'mla'); ?> <small><?php echo 'v'. $options->plugin_version; ?></small></h1>
  <form action="<?php echo menu_page_url($options->options_page_slug, false ); ?>" method="post">
    <div id="dashboard-widgets-wrap">

      <div id="dashboard-widgets" class="metabox-holder">

        <div id="postbox-container-1" class="postbox-container">

          <div id="normal-sortables" class="meta-box-sortables ui-sortable">

            <!-- AT A GLANCE -->
            <div id="dashboard_right_now" class="postbox panel-options">
              <div class="postbox-header">
                <h2 class="hndle ui-sortable-handle"><?php esc_html_e('At a glance', 'mla'); ?></h2>
                <div class="handle-actions hide-if-no-js">
                  <button type="button" class="handlediv" aria-expanded="true">
                    <span class="screen-reader-text">Toggle panel: At a glance</span>
                    <span class="toggle-indicator" aria-hidden="true"></span>
                </button>
                </div>
              </div>
              <div class="inside">
                <div class="main">
                  <ul>
                    <li class="retries-count"><a href="">54 retries</a></li>
                    <li class="lockouts-count"><a href="">38 lockouts</a></li>
                    <li class="bans-count"><a href="">146 bans</a></li>
                    <li class="whitelisted-count"><a href="">2 whitelisted</a></li>
                  </ul>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui magni ullam veritatis accusantium animi molestias quae sequi voluptate quia eveniet.</p>
                </div>
              </div>
            </div>

            <!-- Options -->
            <div id="dashboard_options" class="postbox panel-options">
              <div class="postbox-header">
                <h2 class="hndle ui-sortable-handle"><?php esc_html_e('Options', 'mla'); ?></h2>
                <div class="handle-actions hide-if-no-js">
                  <button type="button" class="handlediv" aria-expanded="true">
                    <span class="screen-reader-text">Toggle panel: Options</span>
                    <span class="toggle-indicator" aria-hidden="true"></span>
                </button>
                </div>
              </div>
              <div class="inside">
                <div class="main">
                  
                  <table class="form-table">
                    <tbody>
                      <!-- Allowed Retries -->
                      <tr>
                        <th scope="row"><label class="" for="allowed_retries"><?php esc_html_e('Allowed Retries', 'mla'); ?></label></th>
                        <td>
                          <input
                            name="allowed_retries"
                            type="number"
                            min="3"
                            max="10"
                            step="1"
                            value="<?php echo($options->get_option('allowed_retries')); ?>"
                          />
                          <span class="mm-item-caption"><?php esc_html_e('allowed retries', 'mla'); ?></span>
                        </td>
                      </tr>
                      <!-- Allowed Lockouts -->
                      <tr>
                        <th scope="row"><label class="" for="allowed_lockouts"><?php esc_html_e('Allowed Lockouts', 'mla'); ?></label></th>
                        <td>
                          <input
                            name="allowed_lockouts"
                            type="number"
                            min="3"
                            max="10"
                            step="1"
                            value="<?php echo($options->get_option('allowed_lockouts')); ?>"
                          />
                          <span class="mm-item-caption"><?php esc_html_e('allowed lockouts', 'mla'); ?></span>
                        </td>
                      </tr>
                      <!-- Lockout Duration -->
                      <tr>
                        <th scope="row"><label class="" for="lockout_duration"><?php esc_html_e('Lockout Duration', 'mla'); ?></label></th>
                        <td>
                          <input
                            name="lockout_duration"
                            type="number"
                            min="15"
                            max="60"
                            step="1"
                            value="<?php echo($options->get_option('lockout_duration') / 60); ?>"
                          />
                          <span class="mm-item-caption"><?php esc_html_e('minutes lockout', 'mla'); ?></span>
                        </td>
                      </tr>

                    </tbody>
                  </table>

                  <div class="buttons">
                    <input class="button button-primary" name="mla_update_settings" value="<?php echo __( 'Save Settings', 'mla' ); ?>" type="submit"/>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

        <div id="postbox-container-2" class="postbox-container">

          <div id="side-sortables" class="meta-box-sortables ui-sortable">
            <!-- Activity -->
            <div id="dashboard_activity" class="postbox panel-options">
              <div class="postbox-header">
                <h2 class="hndle ui-sortable-handle"><?php esc_html_e('Activity', 'mla'); ?></h2>
                <div class="handle-actions hide-if-no-js">
                  <button type="button" class="handlediv" aria-expanded="true">
                    <span class="screen-reader-text">Toggle panel: Activity</span>
                    <span class="toggle-indicator" aria-hidden="true"></span>
                </button>
                </div>
              </div>
              <div class="inside">
                <div id="activity-widget">
                  <div id="latest-comments" class="activity-block table-view-list">
                    <h3>Recent Activity</h3>
                    <ul id="the-comment-list">
                      <li class="comment even comment-item">
                        <div class="dashboard-comment-wrap has-row-actions">
                          <p class="comment-meta">IP <cite class="comment-author"><a href="">127.0.0.1</a></cite> was <strong>banned</strong></p>
                          <p class="row-actions">
                            <span class="ban"><a href="">Ban</a></span> | 
                            <span class="unban"><a href="">Unban</a></span> | 
                            <span class="whitelist"><a href="">Whitelist</a></span>
                          </p>
                        </div>
                      </li>
                      <li class="comment odd comment-item">
                        <div class="dashboard-comment-wrap has-row-actions">
                          <p class="comment-meta">User <cite class="comment-author"><a href="">admin</a></cite> was <strong>locked out</strong></p>
                          <p class="row-actions">
                            <span class="ban"><a href="">Ban</a></span> | 
                            <span class="unban"><a href="">Unban</a></span> | 
                            <span class="whitelist"><a href="">Whitelist</a></span>
                          </p>
                        </div>
                      </li>
                      <li class="comment even comment-item">
                        <div class="dashboard-comment-wrap has-row-actions">
                          <p class="comment-meta">IP <cite class="comment-author"><a href="">10.0.0.1</a></cite> had a <strong>retry</strong></p>
                          <p class="row-actions">
                            <span class="ban"><a href="">Ban</a></span> | 
                            <span class="unban"><a href="">Unban</a></span> | 
                            <span class="whitelist"><a href="">Whitelist</a></span>
                          </p>
                        </div>
                      </li>
                    </ul>
                    <ul class="subsubsub">
                      <li class="all"><a href="">All</a></li>
                      <li class="retries"><a href="">Retries</a></li>
                      <li class="locked"><a href="">Locked</a></li>
                      <li class="banned"><a href="">Banned</a></li>
                      <li class="whitelisted"><a href="">Whitelisted</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

        <div id="postbox-container-3" class="postbox-container">
	        <div id="column3-sortables" class="meta-box-sortables ui-sortable empty-container" data-emptystring="Drag boxes here"></div>
        </div>

        <div id="postbox-container-4" class="postbox-container">
	        <div id="column4-sortables" class="meta-box-sortables ui-sortable empty-container" data-emptystring="Drag boxes here"></div>
        </div>

      </div>

    </div>
  </form>
</div>