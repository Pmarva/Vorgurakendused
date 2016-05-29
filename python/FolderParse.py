import os
import eyed3
import MySQLdb as db
import sys
import hashlib


eyed3.log.setLevel("ERROR")

files = []

rootDir = '/sdc1/kola/mjiusik/Eesti/'
for dirName, subdirList, fileList in os.walk(rootDir, topdown=True):
    #print('Found directory: %s' % dirName)
    for fname in fileList:
        #print('\t%s' % os.path.join(dirName, fname))
        files.append(os.path.join(dirName, fname))


con = db.connect(host='localhost',user='marvin',passwd='marva112',db='mp3',unix_socket='/ram/mysqld/mysqld.sock',charset='utf8')
cur = con.cursor()

numOfFiles = len(files)
curFile=0

for filePath in files:
    file = eyed3.load(filePath)




    BLOCKSIZE = 65536
    hasher = hashlib.sha1()
    with open(filePath, 'rb') as afile:
        buf = afile.read(BLOCKSIZE)
        while len(buf) > 0:
            hasher.update(buf)
            buf = afile.read(BLOCKSIZE)

    #location = "/home/marvin/public_html/python/muusika/veski.mp3"
# print "location %s" % type(location[13:])
# print "Title %s"% type(file.tag.title)
# print "artist   %s" % type(file.tag.artist)
# print "album    %s" % type(file.tag.album)
# print "genre id %s" % type(str(file.tag.genre.id))
# print "genre ni %s" % type(file.tag.genre.name)
# print "aasta    %s" % type(str(file.tag.best_release_date))
# print "suurus   %s" % type(file.info.size_bytes)
# print "pikkus s %s" % type(file.info.time_secs)
# print "bitrate  %s" % type(file.info.bit_rate[1])
# print("hash     %s" % type(hasher.hexdigest()))

    name =  filePath[19:]
    try:
        title = file.tag.title
    except AttributeError:
        title=''
    try:
        artist = file.tag.artist
    except AttributeError:
        artist=''
    try:
        album = file.tag.album
    except AttributeError:
        album=''
    try:
        genreId = str(file.tag.genre.id)
    except AttributeError:
        genreId=''
    try:
        genreName = file.tag.genre.name
    except AttributeError:
        genreName=''
    try:
        year = str(file.tag.best_release_date)
    except AttributeError:
        year=''
    try:
        size = str(file.info.size_bytes)
    except AttributeError:
        size =''
    try:
        length = str(file.info.time_secs)
    except AttributeError:
        length=''
    try:
        bitrate = str(file.info.bit_rate[1])
    except AttributeError:
        bitrate = ''

    hash = str(hasher.hexdigest())

    try:

        cur.execute("""INSERT INTO muusika (Name, Title, Artist, Album, Length, Size, Bitrate, Year, Genre_id, Genre, Hash) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)""",(name,title,artist,album,length,size,bitrate,year,genreId,genreName,hash))
        con.commit()
    except:
        con.rollback()
        e = sys.exc_info()[0]
        print e
        sys.exit(1)

        #print file.info.time_secs
        #tag.getTitle()

        #if mp3.isMp3File(filePath):
        #   print "oige v2rk"

    curFile=curFile+1
    print str(curFile) + "/" + str(numOfFiles) + " working on "+ filePath[19:]
con.close()

