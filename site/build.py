# Wraps src/<page>.html fragments (with optional <!--TITLE:..--> and <style>/<script> inside) into full documents.
import os,re,sys
HEAD='''<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>{title}</title>
<meta name="description" content="{desc}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:ital,wdth,wght@0,62..125,100..900;1,62..125,100..900&family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600&display=swap">
<link rel="stylesheet" href="site.css">
</head>
<body>
<header data-site-nav></header>
'''
TAIL='''
<footer data-site-footer></footer>
<script src="site.js"></script>
{scripts}
</body>
</html>
'''
for f in sorted(os.listdir('src')):
    s=open('src/'+f).read()
    title=re.search(r'<!--TITLE:(.*?)-->',s).group(1).strip()
    desc=re.search(r'<!--DESC:(.*?)-->',s).group(1).strip()
    s=re.sub(r'<!--(TITLE|DESC):.*?-->\n?','',s)
    scripts='\n'.join(re.findall(r'<script data-page>.*?</script>',s,re.S))
    s=re.sub(r'<script data-page>.*?</script>','',s,flags=re.S)
    open(f,'w').write(HEAD.format(title=title,desc=desc)+s+TAIL.format(scripts=scripts))
    print('built',f)
