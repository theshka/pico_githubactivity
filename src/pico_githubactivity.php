<?php

/**
 * Add your public GitHub activity stream to Pico!
 *
 * @author Tyler Heshka
 * @link https://keybase.io/theshka
 * @example http://heshka.com/projects
 * @license http://opensource.org/licenses/MIT
 * @version 0.0.0
 */
 
class Pico_GitHubActivity {
	
	//Load config
	public function config_loaded(&$settings)
	{	
		//Is the username set?
		if (isset($settings['GitHub']['username']))
		{
			$this->GH_USER = $settings['GitHub']['username'];
		}
		
		//How many posts to show?
		if (isset($settings['GitHub']['posts']))
		{
			$this->GH_POSTS = $settings['GitHub']['posts'];
		}
		else
		{
			//default is 10...
			$this->GH_POSTS = 10;
		}
        
	}
	
	//Build the API script
	public function build_script() 
	{
		//Only build the script if username is set
		if (isset($this->GH_USER) && $this->GH_USER != '') {
		
			$script = '
			<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
			<script>
			if($(\'#github\').length){
				$.get(\'https://api.github.com/users/' . $this->GH_USER . '/events/public\', function(data){
					if(data.length){
						$.each(data, function(idx, event){
							if(idx > ' . $this->GH_POSTS . ') return;
			
							var template = $(\'<li />\').addClass(\'github-event \'+ event.type),
								eventTime = $(\'<div />\').addClass(\'event-time\').text(moment(event.created_at).fromNow()),
								eventContent = null;
			
							if(event.type == \'CreateEvent\'){
								eventContent = \'<div class="event-content">Created a <span class="type">\'+ event.payload.ref_type +\'</span> @ <a href="http://github.com/\'+ event.repo.name +\'" target="_blank">\'+ event.repo.name +\'</a></div>\';
							}
							if(event.type == \'DeleteEvent\'){
								eventContent = \'<div class="event-content">Deleted a <span class="type">\'+ event.payload.ref_type +\'</span> @ <a href="http://github.com/\'+ event.repo.name +\'" target="_blank">\'+ event.repo.name +\'</a></div>\';
							}
							if(event.type == \'PushEvent\'){
								eventContent = \'<div class="event-content">Pushed <span class="count">\'+ event.payload.size +\'</span> commits to <a href="http://github.com/\'+ event.repo.name +\'" target="_blank">\'+ event.repo.name +\'</a></div>\';
							}
							if(event.type == \'IssueCommentEvent\'){
								eventContent = \'<div class="event-content">Commented on <a href="\'+ event.payload.issue.html_url +\'" target="_blank">\'+ event.payload.issue.title +\'</a></div>\';
							}
			
							if(eventContent){
								template.append(eventTime);
								template.append(eventContent);
								$(\'#github\').append(template);
							}
						});
					}
				});
			}
			</script>		
			';
		}
		
		//return the built script
		return $script;
	}
	
	//Build HTML/Twig var {{ GitHub }}
	public function before_render(&$twig_vars, &$twig)
	{
		// assign {{ GitHub }} to twig_vars
		$twig_vars['GitHub'] = '
		
		<style>

			/* Feed Style
			/*---------------------------------------------*/
			ul {
				padding-left: 0px !important;
			}
			#github {
				list-style: none;
				padding: 0;
				margin: 0;
			}
			#github li {
				padding: 10px 0;
				text-overflow: ellipsis;
				white-space: nowrap;
				overflow: hidden;
			}
			 .github-event div { display: inline-block; }
			 .github-event .event-time {
				width: 200px;
				border: 2px solid #aaa;
				font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
				font-size: 1.5rem;
				font-weight: normal;
				text-align: center;
				color: #999;
				margin-right: 20px;
			}
			.github-event .event-content {
				font-size: 1.5rem;
			}
			.github-event .event-content span { font-weight: bold; }
			
			/* Mobile Styles
			/*---------------------------------------------*/
			
			/* Small Devices, Tablets */
			@media only screen and (max-width : 768px) {
				
				#github {

				}
				#github li {
					padding: 5px 0;
				}
			
				.github-event .event-time {
					width: 125px;
					font-size: 1rem;
					margin-right: 20px;
				}
				.github-event .event-content {
					font-size: 1rem;
				}
					
			}
			
			/* Extra Small Devices, Phones */ 
			@media only screen and (max-width : 480px) {
				
				#github {

				}
				#github li {
					padding: 1px 0;
				}
			
				.github-event .event-time {
					width: 75px;
					font-size: .5rem;
					margin-right: 20px;
				}
				.github-event .event-content {
					font-size: .5rem;
				}
			
			}


		</style>
		<hr>
		<h2><a href="http://github.com/' . $this->GH_USER . '">@' . $this->GH_USER . '</a>\'s Recent GitHub Activity</h2>
		<ul id="github"></ul>
		';
		
		return;
	}
	
	// Inject script in to document
	public function after_render(&$output)
	{
		//Output plugin
		$output = str_replace('</body>', PHP_EOL . $this->build_script() . '</body>', $output);	
	}
	
}
