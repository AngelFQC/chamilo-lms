<div id="navigation" class="notification-panel">
    {{ help_content }}
    {{ bug_notification }}
</div>
{% block topbar %}
    {% include template ~ "/layout/topbar.tpl" %}
{% endblock %}
<div class="extra-header">{{ header_extra_content }}</div>
<header id="header-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="logo">
                    {{ logo }}
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="bar-top">
                            <script>
                                $(document).on('ready', function () {
                                    $("#notifications").load("{{ _p.web_main }}inc/ajax/online.ajax.php?a=get_users_online");
                                });
                            </script>
                            <div class="section-notifications">
                                <ul id="notifications" class="nav nav-pills pull-right">
                                </ul>
                            </div>
                            {{ accessibility }}
                        </div>
                        <div class="login-top navbar-right">
                            {% if _u.logged  == 0 %}
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ 'LoginAsThisUser' | get_lang }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        {% include template ~ "/layout/login_form.tpl" %}
                                    </li>
                                </ul>
                              </div>
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
{% block menu %}
    {% include template ~ "/layout/menu.tpl" %}
{% endblock %}
{% include template ~ "/layout/course_navigation.tpl" %}
