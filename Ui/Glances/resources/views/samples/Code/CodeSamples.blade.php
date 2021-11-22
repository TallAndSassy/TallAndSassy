
                <x-jet-section-border/>
                  <x-grok::action-section>
                    <x-slot name="title">
                       Show Code Samples
                    </x-slot>

                    <x-slot name="description">
                        <div class="text-xs">
                        code
                        </div>
                    </x-slot>
                      <x-slot name="content">
                          You can show code like this css
                          <pre><code class="language-css">p { color: red }</code></pre>
                          by encasing in
                          For example...
                          @php
                          $sample =<<<EOD
                          <pre><code class="language-css"> p { color: red } </code></pre>
                          EOD;
                          $sampleEscaped =  htmlspecialchars($sample);
                          @endphp
                          <pre><code class="language-html">{!!  $sampleEscaped !!}</code></pre>

                          <hr>

                          <x-grok::title>Escaping</x-grok::title>
                          Since the browser will render html, we need to escape our samples.
                          @php
                          $sample =<<<EOL
                          --- in php ---
                          \$sample =<<<EOD
                          <pre><code class="language-css"> p { color: red } </code></pre>
                          EOD;
                          \$sampleEscaped =  htmlspecialchars(\$sample);

                          ---- in html/blade ----
                          <pre><code class="language-php">{!!  \$sampleEscaped !!}</code></pre>
                          EOL;
                          $sampleEscaped =  htmlspecialchars($sample);
                          @endphp

                           <pre><code class="language-php">{!!  $sampleEscaped !!}</code></pre>
                          <hr>

                          <x-grok::title>Loading from file</x-grok::title>
                          If you are loading the sample code from a file, you can do something like this...
                           @php
                          $sample =<<<EOL
                          <x-grok::tas-sample-from-file language="php" path="vendor/eleganttechnologies/grok/resources/views/grok/grok/sample_code/short.blade.php"/>
                          EOL;
                          $sampleEscaped =  htmlspecialchars($sample);
                          @endphp
                          <pre><code class="language-php">{!!  $sampleEscaped !!}</code></pre>
                          Which will yield...
                          <x-grok::tas-sample-from-file language="php" path="vendor/eleganttechnologies/grok/resources/views/grok/grok/sample_code/short.blade.php"/>
                          The required parameters are 'language' and 'path', where 'path' is off the app root directory
                          and language is (php,html,javascript,console,css);
                          <hr>



                    </x-slot>
                  </x-grok::action-section>
