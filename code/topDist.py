# cd ~/Sites/combine/code
import re
import json
import MySQLdb
import numpy as np
import pandas as pd
import pandas.io.sql as psql



def loadData(query):
	mysql_cn = MySQLdb.connect(host='localhost',user='root', passwd='ivy7paul',db='Jaguars')
	df_mysql = psql.frame_query(query, con=mysql_cn)    
	print 'loaded dataframe from MySQL. records:', len(df_mysql)
	mysql_cn.close()
	return df_mysql

events = [ 'ht', 'arm', 'hand' ] + ['dash40', 'dash20', 'dash10', 'bench', 'vert', 'broad', 'shuttle', 'cone' ]


query = "SELECT adjAv, d.first, d.last, d.pos, "+', '.join(events)+" FROM dsCombine d JOIN pfrPlayers p ON p.nflId=d.nflId "
df = loadData(query)
# df = df.fillna('NULL')
# df = df.replace('NULL', np.nan)
topDist = {}

for p in df.pos.unique():
	tmp = df[df.pos==p].sort('adjAv', ascending=0)
	# print tmp.head(30)
	topDist[p] = {}
	for e in events:
		d = {}
		i = 0
		mx = np.max(tmp.head(30)[e])
		mn = np.min(tmp.head(30)[e])
		topDist[p][e] = {}
		if e in [ 'dash40', 'dash20', 'dash10', 'shuttle', 'cone' ]:
			for i in np.arange(mn, mx, .01):
				topDist[p][e][str(i)] = 0
		elif e in [ 'vert' ]:
			for i in np.arange(mn, mx, .5):
				topDist[p][e][str(i)] = 0
		elif e in [ 'vert' ]:
			for i in np.arange(mn, mx, .5):
				topDist[p][e][str(i)] = 0
		elif e in [ 'arm' ]:
			for i in np.arange(mn, mx, .25):
				topDist[p][e][str(i)] = 0
		elif e in [ 'hand' ]:
			for i in np.arange(mn, mx, .125):
				topDist[p][e][str(round(i,2))] = 0
		elif e in [ 'broad' ]:
			for i in np.arange(mn, mx, 1./12.):
				topDist[p][e][str(round(i,2))] = 0
		else:
			for i in np.arange(mn, mx):
				topDist[p][e][str(i)] = 0


		for row in tmp.head(30).iterrows():
			# i += 1
			# if i>30: break
			row = row[1]
			if not row[e]==row[e]:
				continue
			val = str(row[e])
			if not val in d:
				d[val] = 0
			d[val] += 1
		for v, a in d.items():
			topDist[p][e][v] = a

		topDist[p][e]['values'] = []
		for v, a in topDist[p][e].items():
			if v=='values': continue
			if not v==v: 
				print v
				continue
			topDist[p][e]['values'].append({'measure':float(v), 'amount':a})

		topDist[p][e]['values'] = sorted(topDist[p][e]['values'], key=lambda k: k['measure']) 

with open('../data/json/topDist.json', 'w') as fp:
	json.dump(topDist, fp)
