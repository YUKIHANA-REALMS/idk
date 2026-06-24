-- Reset site branding settings to Indium Panel defaults
UPDATE setting_option SET setting_value = 'Indium Panel' WHERE setting_key = 'site_title';
UPDATE setting_option SET setting_value = 'Indium Panel' WHERE setting_key = 'site_name';
UPDATE setting_option SET setting_value = '' WHERE setting_key = 'site_logo';
UPDATE setting_option SET setting_value = '' WHERE setting_key = 'site_landing_logo';
UPDATE setting_option SET setting_value = '' WHERE setting_key = 'site_email_logo';
UPDATE setting_option SET setting_value = '' WHERE setting_key = 'site_favicon';

-- Reset landing page sections to Indium Panel defaults
UPDATE landing_page_section SET content = '{"site_title":"Indium Panel","site_description":"Game servers, served cold. Open-source panel that runs where you tell it to.","logo_url":"","favicon_url":""}' WHERE section_type = 'general';

UPDATE landing_page_section SET content = '{"background_color":"#000000","text_color":"#ffffff","links":[{"text":"Home","url":"/","is_active":true},{"text":"Store","url":"/store","is_active":true},{"text":"Login","url":"/login","is_active":true},{"text":"Register","url":"/register","is_active":true}],"button_color":"#4287f5","button_text_color":"#ffffff"}' WHERE section_type = 'navbar';

UPDATE landing_page_section SET content = '{"title":"Indium Panel","subtitle":"Game servers, served cold. Open-source panel that runs where you tell it to. No vendor lock, no surprises.","background_type":"color","background_color":"#000000","background_image":"","background_video":"","text_color":"#ffffff","buttons":[{"text":"Get Started","url":"/register","color":"#4287f5","text_color":"#ffffff","style":"filled"},{"text":"Documentation","url":"#","color":"transparent","text_color":"#ffffff","style":"outlined"}]}' WHERE section_type = 'hero';

UPDATE landing_page_section SET content = '{"title":"Why Choose Indium?","subtitle":"Built for performance, designed for simplicity.","background_color":"#0a0a0a","text_color":"#ffffff","items":[{"title":"Open Source","description":"Fully open source with no vendor lock-in.","icon":"fa-code","color":"#4287f5"},{"title":"Fast & Reliable","description":"Optimized for speed and uptime.","icon":"fa-bolt","color":"#22c55e"},{"title":"Easy Setup","description":"Deploy in minutes, not hours.","icon":"fa-rocket","color":"#f59e0b"}]}' WHERE section_type = 'features';

UPDATE landing_page_section SET content = '{"title":"Our Products","subtitle":"Choose the perfect plan for your game server.","background_color":"#000000","text_color":"#ffffff","card_style":"rounded","card_border_radius":"16px","card_shadow":true,"card_shadow_color":"rgba(66,135,245,0.15)","card_shadow_blur":"20px","card_background":"#0a0a0a","card_border_color":"#222222","card_hover":true,"card_hover_scale":1.02,"button_text":"Order Now","button_color":"#4287f5","button_text_color":"#ffffff","layout":"grid"}' WHERE section_type = 'products';

UPDATE landing_page_section SET content = '{"title":"Ready to Get Started?","subtitle":"Deploy your game server in seconds.","background_color":"#0a0a0a","text_color":"#ffffff","buttons":[{"text":"Get Started","url":"/register","color":"#4287f5","text_color":"#ffffff","style":"filled"}]}' WHERE section_type = 'cta';

UPDATE landing_page_section SET content = '{"background_color":"#000000","text_color":"#888888","links":[{"text":"Terms","url":"/terms"},{"text":"Privacy","url":"/privacy"},{"text":"Support","url":"/support"}],"copyright_text":"All rights reserved.","social_links":[],"show_logo":true}' WHERE section_type = 'footer';
