
              <?php
                /*
                 * This is the default post format.
                 *
                 * So basically this is a regular post. if you don't want to use post formats,
                 * you can just copy ths stuff in here and replace the post format thing in
                 * single.php.
                 *
                 * The other formats are SUPER basic so you can style them as you like.
                 *
                 * Again, If you want to remove post formats, just delete the post-formats
                 * folder and replace the function below with the contents of the "format.php" file.
                */
              ?>

              <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                <div class="article-date d-1of5">
                  <span class="month"><?php echo get_the_time('F'); ?></span>
                  <span class="day"><?php echo get_the_time('j'); ?></span>
                  <span class="year"><?php echo get_the_time('Y'); ?></span>
                </div>
                
                <div class="article-content d-4of5">
                  <header class="article-header">

                    <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>

                  </header> <?php // end article header ?>

                  <section class="entry-content cf" itemprop="articleBody">
                    <?php the_post_thumbnail('medium'); ?>
                    <?php
                      // the content (pretty self explanatory huh)
                      the_content();

                    ?>
                  </section> <?php // end article section ?>

                  <footer class="article-footer"></footer> <?php // end article footer ?>

                </div>

              </article> <?php // end article ?>