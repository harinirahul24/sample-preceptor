
#!/bin/bash
if ! [ -x "$(command systemctl start httpd)" ]; then systemctl start httpd24 >&2;   exit 126; fi # install apache if not already installed




