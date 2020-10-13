<?php
/**
 * Template Name: Typography
 */
get_header(); ?>
<div id="main-content">
    <div class="entry-content">
        <h2 id="fluid-grid" class="typo-title">Fluid grid system</h2>
        <hr>
        <div class="bs-docs-grid">
            <div class="row-fluid show-grid">
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
                <div class="span1">1</div>
            </div>
            <div class="row-fluid show-grid">
                <div class="span4">4</div>
                <div class="span4">4</div>
                <div class="span4">4</div>
            </div>
            <div class="row-fluid show-grid">
                <div class="span4">4</div>
                <div class="span8">8</div>
            </div>
            <div class="row-fluid show-grid">
                <div class="span6">6</div>
                <div class="span6">6</div>
            </div>
            <div class="row-fluid show-grid">
                <div class="span12">12</div>
            </div>
        </div>

        <!-- End Fluid grid system -->
        
        <h2 class="typo-title">Headings</h2>
        <hr>
        <div class="bs-docs-example">
            <h1>h1. Heading 1</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <h2>h2. Heading 2</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <h3>h3. Heading 3</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <h4>h4. Heading 4</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <h5>h5. Heading 5</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <h6>h6. Heading 6</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>

        <h2 class="typo-title">Blockquotes</h2>
        <hr>
        <div class="bs-docs-example clearfix">
            <blockquote><p>Quality is more important than quantity. One home run is much better than two doubles.</p>
            <div><cite><strong>Steve Jobs</strong>, Business Week</cite></div>
            </blockquote>
        </div>

        <h2 class="typo-title">Scripts</h2>
        <hr>
        <pre>body {
  color: #555;
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 16px;
  line-height: 24px;
}

p {
  margin: 0 0 12px;
}

h1, h2, h3, h4, h5, h6 {
  color: #333333;
  font-family: 'Roboto Slab', serif;
  font-weight: normal;
  line-height: 24px;
  margin: 12px 0;
  text-rendering: optimizelegibility;
}</pre>

        <div class="row-fluid">
            <div class="span6">
                <h2 class="typo-title">Labels</h2>
                <hr>
                <p><span class="label">Default</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="label label-success">Success</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="label label-warning">Warning</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="label label-important">Important</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="label label-info">Info</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="label label-inverse">Inverse</span> Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="span6">
                <h2 class="typo-title">Badges</h2>
                <hr>
                <p><span class="badge">1</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="badge badge-success">2</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="badge badge-warning">4</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="badge badge-important">6</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="badge badge-info">8</span> Lorem ipsum dolor sit amet.</p>
                <p><span class="badge badge-inverse">10</span> Lorem ipsum dolor sit amet.</p>
            </div>
        </div>
        <h2 class="typo-title">Alert messages</h2>
        <hr>
        <div class="row-fluid">
            <div class="span6">
                <div class="alert fade in">
                    <strong>Alert!</strong> lorem Ipsum has been the industry's.
                </div>

                <div class="alert alert-error fade in">
                    <strong>Error!</strong> desktop publishing packages and web page.
                </div>
            </div>

            <div class="span6">
                <div class="alert alert-success fade in">
                    <strong>Success!</strong>piece of classical literature from 45 BC.
                </div>

                <div class="alert alert-info fade in">
                    <strong>Info!</strong> all the Lorem Ipsum literature generators.
                </div>
            </div>
        </div>

        <h2 class="typo-title">Buttons</h2>
        <hr>
        <div class="demo-btn-group">
            <div class="wrap">
                <button class="btn btn-mini" type="button">Default</button>
                <button class="btn btn-mini btn-primary" type="button">Primary</button>
                <button class="btn btn-mini btn-info" type="button">Info</button>
                <button class="btn btn-mini btn-success first-s" type="button">Success</button>
                <button class="btn btn-mini btn-warning first sl-s" type="button">Warning</button>
                <button class="btn btn-mini btn-danger sl sl-s" type="button">Danger</button>
                <button class="btn btn-mini btn-inverse sl first-s" type="button">Inverse</button>
                <button class="btn btn-mini btn-link sl sl-s" type="button">Link</button>
            </div>

            <div class="wrap">
                <button class="btn btn-small" type="button">Default</button>
                <button class="btn btn-small btn-primary" type="button">Primary</button>
                <button class="btn btn-small btn-info" type="button">Info</button>
                <button class="btn btn-small btn-success first-s" type="button">Success</button>
                <button class="btn btn-small btn-warning first sl-s" type="button">Warning</button>
                <button class="btn btn-small btn-danger sl sl-s" type="button">Danger</button>
                <button class="btn btn-small btn-inverse sl first-s" type="button">Inverse</button>
                <button class="btn btn-small btn-link sl sl-s" type="button">Link</button>
            </div>

            <div class="wrap">
                <button class="btn" type="button">Default</button>
                <button class="btn btn-primary" type="button">Primary</button>
                <button class="btn btn-info first-s" type="button">Info</button>
                <button class="btn btn-success sl-s" type="button">Success</button>
                <button class="btn btn-warning first first-s" type="button">Warning</button>
                <button class="btn btn-danger sl sl-s" type="button">Danger</button>
                <button class="btn btn-inverse sl first-s" type="button">Inverse</button>
                <button class="btn btn-link sl sl-s" type="button">Link</button>
            </div>

            <div class="wrap">
                <button class="btn btn-large" type="button">Default</button>
                <button class="btn btn-large btn-primary" type="button">Primary</button>
                <button class="btn btn-large btn-info first-s" type="button">Info</button>
                <button class="btn btn-large btn-success first sl-s" type="button">Success</button>
                <button class="btn btn-large btn-warning sl first-s" type="button">Warning</button>
                <button class="btn btn-large btn-danger sl sl-s" type="button">Danger</button>
                <button class="btn btn-large btn-inverse first first-s" type="button">Inverse</button>
                <button class="btn btn-large btn-link sl sl-s" type="button">Link</button>
            </div>
        </div>    
        
        <div class="row-fluid">
            <div class="span6">
                <h2 class="typo-title">Tabs</h2>
                <hr>
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#tab-1" data-toggle="tab">Tab 1</a></li>
                    <li><a href="#tab-2" data-toggle="tab">Tab 2</a></li>
                    <li><a href="#tab-3" data-toggle="tab">Tab 3</a></li>
                </ul>
                 
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-1">
                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                    </div>

                    <div class="tab-pane" id="tab-2">
                        Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still
                    </div>

                    <div class="tab-pane" id="tab-3">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </div>
                </div>
            </div>

            <div class="span6">
                <h2 class="typo-title">Accordion</h2>
                <hr>
                <div class="accordion" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                            Collapsible Group Item #1
                            </a>
                        </div>

                        <div id="collapseOne" class="accordion-body collapse in">
                            <div class="accordion-inner">
                            Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still
                            </div>
                        </div>
                    </div>

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                            Collapsible Group Item #2
                            </a>
                        </div>

                        <div id="collapseTwo" class="accordion-body collapse">
                            <div class="accordion-inner">
                            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                            Collapsible Group Item #3
                            </a>
                        </div>

                        <div id="collapseThree" class="accordion-body collapse">
                            <div class="accordion-inner">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="typo-title">Icons</h2>
        <hr>
        <ul class="the-icons clearfix">
            <li><i class="icon-glass"></i> icon-glass</li>
            <li><i class="icon-music"></i> icon-music</li>
            <li><i class="icon-search"></i> icon-search</li>
            <li><i class="icon-envelope"></i> icon-envelope</li>
            <li><i class="icon-heart"></i> icon-heart</li>
            <li><i class="icon-star"></i> icon-star</li>
            <li><i class="icon-star-empty"></i> icon-star-empty</li>
            <li><i class="icon-user"></i> icon-user</li>
            <li><i class="icon-film"></i> icon-film</li>
            <li><i class="icon-th-large"></i> icon-th-large</li>
            <li><i class="icon-th"></i> icon-th</li>
            <li><i class="icon-th-list"></i> icon-th-list</li>
            <li><i class="icon-ok"></i> icon-ok</li>
            <li><i class="icon-remove"></i> icon-remove</li>
            <li><i class="icon-zoom-in"></i> icon-zoom-in</li>
            <li><i class="icon-zoom-out"></i> icon-zoom-out</li>
            <li><i class="icon-off"></i> icon-off</li>
            <li><i class="icon-signal"></i> icon-signal</li>
            <li><i class="icon-cog"></i> icon-cog</li>
            <li><i class="icon-trash"></i> icon-trash</li>
            <li><i class="icon-home"></i> icon-home</li>
            <li><i class="icon-file"></i> icon-file</li>
            <li><i class="icon-time"></i> icon-time</li>
            <li><i class="icon-road"></i> icon-road</li>
            <li><i class="icon-download-alt"></i> icon-download-alt</li>
            <li><i class="icon-download"></i> icon-download</li>
            <li><i class="icon-upload"></i> icon-upload</li>
            <li><i class="icon-inbox"></i> icon-inbox</li>

            <li><i class="icon-play-circle"></i> icon-play-circle</li>
            <li><i class="icon-repeat"></i> icon-repeat</li>
            <li><i class="icon-refresh"></i> icon-refresh</li>
            <li><i class="icon-list-alt"></i> icon-list-alt</li>
            <li><i class="icon-lock"></i> icon-lock</li>
            <li><i class="icon-flag"></i> icon-flag</li>
            <li><i class="icon-headphones"></i> icon-headphones</li>
            <li><i class="icon-volume-off"></i> icon-volume-off</li>
            <li><i class="icon-volume-down"></i> icon-volume-down</li>
            <li><i class="icon-volume-up"></i> icon-volume-up</li>
            <li><i class="icon-qrcode"></i> icon-qrcode</li>
            <li><i class="icon-barcode"></i> icon-barcode</li>
            <li><i class="icon-tag"></i> icon-tag</li>
            <li><i class="icon-tags"></i> icon-tags</li>
            <li><i class="icon-book"></i> icon-book</li>
            <li><i class="icon-bookmark"></i> icon-bookmark</li>
            <li><i class="icon-print"></i> icon-print</li>
            <li><i class="icon-camera"></i> icon-camera</li>
            <li><i class="icon-font"></i> icon-font</li>
            <li><i class="icon-bold"></i> icon-bold</li>
            <li><i class="icon-italic"></i> icon-italic</li>
            <li><i class="icon-text-height"></i> icon-text-height</li>
            <li><i class="icon-text-width"></i> icon-text-width</li>
            <li><i class="icon-align-left"></i> icon-align-left</li>
            <li><i class="icon-align-center"></i> icon-align-center</li>
            <li><i class="icon-align-right"></i> icon-align-right</li>
            <li><i class="icon-align-justify"></i> icon-align-justify</li>
            <li><i class="icon-list"></i> icon-list</li>

            <li><i class="icon-indent-left"></i> icon-indent-left</li>
            <li><i class="icon-indent-right"></i> icon-indent-right</li>
            <li><i class="icon-facetime-video"></i> icon-facetime-video</li>
            <li><i class="icon-picture"></i> icon-picture</li>
            <li><i class="icon-pencil"></i> icon-pencil</li>
            <li><i class="icon-map-marker"></i> icon-map-marker</li>
            <li><i class="icon-adjust"></i> icon-adjust</li>
            <li><i class="icon-tint"></i> icon-tint</li>
            <li><i class="icon-edit"></i> icon-edit</li>
            <li><i class="icon-share"></i> icon-share</li>
            <li><i class="icon-check"></i> icon-check</li>
            <li><i class="icon-move"></i> icon-move</li>
            <li><i class="icon-step-backward"></i> icon-step-backward</li>
            <li><i class="icon-fast-backward"></i> icon-fast-backward</li>
            <li><i class="icon-backward"></i> icon-backward</li>
            <li><i class="icon-play"></i> icon-play</li>
            <li><i class="icon-pause"></i> icon-pause</li>
            <li><i class="icon-stop"></i> icon-stop</li>
            <li><i class="icon-forward"></i> icon-forward</li>
            <li><i class="icon-fast-forward"></i> icon-fast-forward</li>
            <li><i class="icon-step-forward"></i> icon-step-forward</li>
            <li><i class="icon-eject"></i> icon-eject</li>
            <li><i class="icon-chevron-left"></i> icon-chevron-left</li>
            <li><i class="icon-chevron-right"></i> icon-chevron-right</li>
            <li><i class="icon-plus-sign"></i> icon-plus-sign</li>
            <li><i class="icon-minus-sign"></i> icon-minus-sign</li>
            <li><i class="icon-remove-sign"></i> icon-remove-sign</li>
            <li><i class="icon-ok-sign"></i> icon-ok-sign</li>

            <li><i class="icon-question-sign"></i> icon-question-sign</li>
            <li><i class="icon-info-sign"></i> icon-info-sign</li>
            <li><i class="icon-screenshot"></i> icon-screenshot</li>
            <li><i class="icon-remove-circle"></i> icon-remove-circle</li>
            <li><i class="icon-ok-circle"></i> icon-ok-circle</li>
            <li><i class="icon-ban-circle"></i> icon-ban-circle</li>
            <li><i class="icon-arrow-left"></i> icon-arrow-left</li>
            <li><i class="icon-arrow-right"></i> icon-arrow-right</li>
            <li><i class="icon-arrow-up"></i> icon-arrow-up</li>
            <li><i class="icon-arrow-down"></i> icon-arrow-down</li>
            <li><i class="icon-share-alt"></i> icon-share-alt</li>
            <li><i class="icon-resize-full"></i> icon-resize-full</li>
            <li><i class="icon-resize-small"></i> icon-resize-small</li>
            <li><i class="icon-plus"></i> icon-plus</li>
            <li><i class="icon-minus"></i> icon-minus</li>
            <li><i class="icon-asterisk"></i> icon-asterisk</li>
            <li><i class="icon-exclamation-sign"></i> icon-exclamation-sign</li>
            <li><i class="icon-gift"></i> icon-gift</li>
            <li><i class="icon-leaf"></i> icon-leaf</li>
            <li><i class="icon-fire"></i> icon-fire</li>
            <li><i class="icon-eye-open"></i> icon-eye-open</li>
            <li><i class="icon-eye-close"></i> icon-eye-close</li>
            <li><i class="icon-warning-sign"></i> icon-warning-sign</li>
            <li><i class="icon-plane"></i> icon-plane</li>
            <li><i class="icon-calendar"></i> icon-calendar</li>
            <li><i class="icon-random"></i> icon-random</li>
            <li><i class="icon-comment"></i> icon-comment</li>
            <li><i class="icon-magnet"></i> icon-magnet</li>

            <li><i class="icon-chevron-up"></i> icon-chevron-up</li>
            <li><i class="icon-chevron-down"></i> icon-chevron-down</li>
            <li><i class="icon-retweet"></i> icon-retweet</li>
            <li><i class="icon-shopping-cart"></i> icon-shopping-cart</li>
            <li><i class="icon-folder-close"></i> icon-folder-close</li>
            <li><i class="icon-folder-open"></i> icon-folder-open</li>
            <li><i class="icon-resize-vertical"></i> icon-resize-vertical</li>
            <li><i class="icon-resize-horizontal"></i> icon-resize-horizontal</li>
            <li><i class="icon-hdd"></i> icon-hdd</li>
            <li><i class="icon-bullhorn"></i> icon-bullhorn</li>
            <li><i class="icon-bell"></i> icon-bell</li>
            <li><i class="icon-certificate"></i> icon-certificate</li>
            <li><i class="icon-thumbs-up"></i> icon-thumbs-up</li>
            <li><i class="icon-thumbs-down"></i> icon-thumbs-down</li>
            <li><i class="icon-hand-right"></i> icon-hand-right</li>
            <li><i class="icon-hand-left"></i> icon-hand-left</li>
            <li><i class="icon-hand-up"></i> icon-hand-up</li>
            <li><i class="icon-hand-down"></i> icon-hand-down</li>
            <li><i class="icon-circle-arrow-right"></i> icon-circle-arrow-right</li>
            <li><i class="icon-circle-arrow-left"></i> icon-circle-arrow-left</li>
            <li><i class="icon-circle-arrow-up"></i> icon-circle-arrow-up</li>
            <li><i class="icon-circle-arrow-down"></i> icon-circle-arrow-down</li>
            <li><i class="icon-globe"></i> icon-globe</li>
            <li><i class="icon-wrench"></i> icon-wrench</li>
            <li><i class="icon-tasks"></i> icon-tasks</li>
            <li><i class="icon-filter"></i> icon-filter</li>
            <li><i class="icon-briefcase"></i> icon-briefcase</li>
            <li><i class="icon-fullscreen"></i> icon-fullscreen</li>
        </ul>
    </div><!-- #entry-content -->
</div><!-- #main-content -->
<?php get_footer(); ?>