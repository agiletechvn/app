echo "Clear all logs, cache files"
find ../tmp -name "*" -type f -print0 | xargs -0 /bin/rm -f
find ../logs -name "*" -type f -print0 | xargs -0 /bin/rm -f
echo "Compressing application"
tar -zcvf deploy.tar.gz ../*
echo "Compressed"
sleep 1